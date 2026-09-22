@extends('admin_layout.app')
@section('title', 'Chat – ' . $other->name . ' | District Studio')

@section('content')
<div class="mailbox-page" style="padding-top: 90px; min-height: 100vh; background: #0a0a0a;">
  <div class="container-fluid px-3 px-md-4" style="max-width: 900px; margin: 0 auto;">

    {{-- Back + Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
      <a href="{{ route('mailbox.index') }}" class="btn btn-sm"
         style="background: rgba(255,255,255,0.07); color: #fff; border-radius: 8px; border: none;">
        <i class="bi bi-arrow-left"></i>
      </a>
      @php
        $avatar = $other->avatar
          ? (str_starts_with($other->avatar, 'http') ? $other->avatar : asset('storage/' . $other->avatar))
          : 'https://ui-avatars.com/api/?name=' . urlencode($other->name) . '&background=dca53e&color=000&size=64&bold=true';
      @endphp
      <img src="{{ $avatar }}" alt="{{ $other->name }}"
           style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(220,165,62,0.4);">
      <div>
        <div style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; font-size: 1rem;">{{ $other->name }}</div>
        <div style="font-size: 0.72rem; color: #71717a;">
          <span class="badge"
                style="font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 50px;
                @if($other->role === 'hair stylist') background: rgba(255,152,0,0.15); color: #ff9800;
                @elseif($other->role === 'receptionist') background: rgba(0,200,200,0.15); color: #00c8c8;
                @elseif($other->role === 'supervisor') background: rgba(100,200,255,0.15); color: #64c8ff;
                @elseif($other->role === 'customer') background: rgba(40,167,69,0.15); color: #6dff9a;
                @else background: rgba(255,255,255,0.07); color: #a1a1aa;
                @endif">
            {{ ucfirst($other->role) }}
          </span>
        </div>
      </div>
      @if($conversation->subject)
        <div class="ms-auto d-none d-md-block" style="font-size: 0.78rem; color: #dca53e; font-weight: 600;">
          <i class="bi bi-tag-fill me-1"></i>{{ $conversation->subject }}
        </div>
      @endif
    </div>

    {{-- ─── Chat Thread ───────────────────────────────────────────────────── --}}
    <div id="chatThread" class="mailbox-thread mb-3 p-3 p-md-4"
         style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; max-height: 520px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px;">

      @forelse($messages as $msg)
        @php $isMine = $msg->sender_id === Auth::id(); @endphp
        <div class="d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }} align-items-end gap-2">
          {{-- Avatar (other side) --}}
          @if(!$isMine)
            @php
              $senderAvatar = $msg->sender->avatar
                ? (str_starts_with($msg->sender->avatar, 'http') ? $msg->sender->avatar : asset('storage/' . $msg->sender->avatar))
                : 'https://ui-avatars.com/api/?name=' . urlencode($msg->sender->name) . '&background=dca53e&color=000&size=64&bold=true';
            @endphp
            <img src="{{ $senderAvatar }}" alt="{{ $msg->sender->name }}"
                 style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 1px solid rgba(220,165,62,0.3);">
          @endif

          <div style="max-width: 72%;">
            @if(!$isMine)
              <div style="font-size: 0.68rem; color: #71717a; margin-bottom: 3px; padding-left: 4px;">{{ $msg->sender->name }}</div>
            @endif
            <div class="chat-bubble {{ $isMine ? 'bubble-mine' : 'bubble-other' }}"
                 style="padding: 10px 14px; border-radius: {{ $isMine ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }};
                        background: {{ $isMine ? 'linear-gradient(135deg, #dca53e, #c88e28)' : 'rgba(255,255,255,0.07)' }};
                        color: {{ $isMine ? '#000' : '#e4e4e7' }};
                        font-size: 0.84rem; line-height: 1.5; word-break: break-word;">
              {{ $msg->body }}
            </div>
            <div style="font-size: 0.63rem; color: #52525b; margin-top: 3px; {{ $isMine ? 'text-align: right; padding-right: 4px;' : 'padding-left: 4px;' }}">
              {{ $msg->created_at->format('d M, H:i') }}
              @if($isMine)
                @if($msg->is_read)
                  <i class="bi bi-check2-all ms-1" style="color: #dca53e;"></i>
                @else
                  <i class="bi bi-check2 ms-1" style="color: #52525b;"></i>
                @endif
              @endif
            </div>
          </div>

          {{-- Avatar (my side) --}}
          @if($isMine)
            @php
              $myAvatar = Auth::user()->avatar
                ? (str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar))
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=28a745&color=fff&size=64&bold=true';
            @endphp
            <img src="{{ $myAvatar }}" alt="Anda"
                 style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 1px solid rgba(40,167,69,0.4);">
          @endif
        </div>
      @empty
        <div class="text-center py-5" style="color: #52525b;">
          <i class="bi bi-chat-dots fs-2 mb-2 d-block" style="color: rgba(220,165,62,0.2);"></i>
          Belum ada pesan. Kirim pesan pertama!
        </div>
      @endforelse
    </div>

    {{-- ─── Reply Box ─────────────────────────────────────────────────────── --}}
    <form action="{{ route('mailbox.reply', $conversation) }}" method="POST"
          class="reply-box p-3"
          style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px;">
      @csrf
      @if($errors->any())
        <div class="alert mb-2" style="background: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.3); color: #ff7b7b; border-radius: 8px; font-size: 0.8rem;">
          {{ $errors->first() }}
        </div>
      @endif
      <div class="d-flex gap-2 align-items-end">
        <textarea name="body" id="replyBody" class="form-control flex-1" rows="2" required
                  placeholder="Tulis balasan..."
                  style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; resize: none; font-size: 0.85rem; flex: 1;"></textarea>
        <button type="submit"
                style="background: linear-gradient(135deg, #dca53e, #f0c060); color: #000; border: none; border-radius: 10px; padding: 10px 18px; font-weight: 800; font-size: 0.9rem; flex-shrink: 0; cursor: pointer; transition: opacity 0.2s;"
                onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
          <i class="bi bi-send-fill"></i>
        </button>
      </div>
    </form>

  </div>
</div>

<script>
  // Auto-scroll to bottom of chat thread
  (function () {
    const thread = document.getElementById('chatThread');
    if (thread) thread.scrollTop = thread.scrollHeight;
  })();

  // Auto-resize textarea
  const replyBody = document.getElementById('replyBody');
  if (replyBody) {
    replyBody.addEventListener('input', function () {
      this.style.height = 'auto';
      this.style.height = Math.min(this.scrollHeight, 150) + 'px';
    });
    // Send on Ctrl+Enter
    replyBody.addEventListener('keydown', function (e) {
      if (e.ctrlKey && e.key === 'Enter') {
        this.closest('form').submit();
      }
    });
  }
</script>
@endsection
