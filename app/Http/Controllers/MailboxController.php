<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MailboxController extends Controller
{
    // ─── 1. Inbox: list all conversations ────────────────────────────────────

    public function index()
    {
        $authId = Auth::id();

        $conversations = Conversation::where('user_one_id', $authId)
            ->orWhere('user_two_id', $authId)
            ->with(['userOne', 'userTwo', 'latestMessage.sender'])
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($conv) use ($authId) {
                $conv->other    = $conv->otherParticipant($authId);
                $conv->unread   = $conv->unreadCountFor($authId);
                return $conv;
            });

        $totalUnread = $conversations->sum('unread');

        // Users this role can start conversations with
        $contacts = $this->getContactsFor(Auth::user());

        return view('mailbox.index', compact('conversations', 'totalUnread', 'contacts'));
    }

    // ─── 2. Show a conversation thread ───────────────────────────────────────

    public function show(Conversation $conversation)
    {
        $authId = Auth::id();

        // Security: only participants can view
        if ($conversation->user_one_id !== $authId && $conversation->user_two_id !== $authId) {
            abort(403, 'Anda tidak memiliki akses ke percakapan ini.');
        }

        // Mark all incoming messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()->with('sender')->get();
        $other    = $conversation->otherParticipant($authId);

        return view('mailbox.show', compact('conversation', 'messages', 'other'));
    }

    // ─── 3. Start / Send: create new conversation or append message ──────────

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id|different:' . Auth::id(),
            'body'         => 'required|string|max:2000',
            'subject'      => 'nullable|string|max:255',
            'booking_id'   => 'nullable|exists:bookings,id',
        ]);

        $authId      = Auth::id();
        $recipientId = (int) $request->recipient_id;

        // Find or create conversation (canonical order: lower id first)
        $conversation = Conversation::findOrCreateBetween(
            $authId,
            $recipientId,
            $request->subject,
            $request->booking_id
        );

        // Append message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $authId,
            'body'            => $request->body,
            'is_read'         => false,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('mailbox.show', $conversation)
            ->with('success', 'Pesan terkirim!');
    }

    // ─── 4. Reply inside existing conversation ────────────────────────────────

    public function reply(Request $request, Conversation $conversation)
    {
        $authId = Auth::id();

        if ($conversation->user_one_id !== $authId && $conversation->user_two_id !== $authId) {
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $authId,
            'body'            => $request->body,
            'is_read'         => false,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('mailbox.show', $conversation)
            ->with('success', 'Balasan terkirim!');
    }

    // ─── 5. AJAX: unread count badge (polling) ────────────────────────────────

    public function unreadCount()
    {
        $authId = Auth::id();

        $count = Message::whereHas('conversation', function ($q) use ($authId) {
            $q->where('user_one_id', $authId)->orWhere('user_two_id', $authId);
        })->where('sender_id', '!=', $authId)
          ->where('is_read', false)
          ->count();

        return response()->json(['unread' => $count]);
    }

    // ─── Helper: who can user contact? ───────────────────────────────────────

    private function getContactsFor(User $user): \Illuminate\Database\Eloquent\Collection
    {
        $role = $user->role;

        // Customer -> receptionist, hair stylist
        if ($role === 'customer') {
            return User::whereIn('role', ['receptionist', 'hair stylist'])->get();
        }

        // Hair Stylist / Receptionist -> customers + each other + supervisor
        if (in_array($role, ['hair stylist', 'receptionist'])) {
            return User::where('id', '!=', $user->id)
                ->whereIn('role', ['customer', 'receptionist', 'hair stylist', 'supervisor'])
                ->get();
        }

        // Supervisor / Admin / Owner -> everyone
        return User::where('id', '!=', $user->id)->get();
    }
}
