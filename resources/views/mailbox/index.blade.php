@extends('admin_layout.app')
@section('title', 'Mailbox – District Studio')

@section('content')
<div class="mailbox-page" style="padding-top: 90px; min-height: 100vh; background: #0a0a0a;">
  <div class="container-fluid px-3 px-md-4" style="max-width: 1200px; margin: 0 auto;">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h1 class="mb-0" style="font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 1.6rem; color: #fff;">
          <i class="bi bi-envelope-paper-fill me-2" style="color: #dca53e;"></i>Mailbox
        </h1>
        <p class="mb-0" style="color: #71717a; font-size: 0.83rem;">Pesan Internal District Studio</p>
      </div>
      @if($totalUnread > 0)
        <span class="badge" style="background: #dca53e; color: #000; font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 0.9rem; padding: 8px 16px; border-radius: 50px;">
          {{ $totalUnread }} Belum Dibaca
        </span>
      @endif
    </div>

    @if(session('success'))
      <div class="alert mb-3" style="background: rgba(40,167,69,0.12); border: 1px solid rgba(40,167,69,0.3); color: #6dff9a; border-radius: 10px; font-size: 0.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
      </div>
    @endif

    <div class="row g-3">
      {{-- ─── LEFT: Conversation List ─────────────────────────────────────── --}}
      <div class="col-lg-4">

        {{-- New Message Button --}}
        <button class="btn w-100 mb-3 d-flex align-items-center justify-content-center gap-2"
                style="background: linear-gradient(135deg, #dca53e, #f0c060); color: #000; font-family: 'Montserrat', sans-serif; font-weight: 800; border-radius: 10px; padding: 12px; border: none;"
                data-bs-toggle="modal" data-bs-target="#newMessageModal">
          <i class="bi bi-pencil-square fs-5"></i> Pesan Baru
        </button>

        {{-- Conversation List --}}
        <div class="mailbox-list" style="border-radius: 14px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06);">
          @forelse($conversations as $conv)
            @php $isActive = request()->is('mailbox/' . $conv->id); @endphp
            <a href="{{ route('mailbox.show', $conv) }}"
               class="d-flex align-items-start gap-3 p-3 mailbox-item text-decoration-none {{ $isActive ? 'mailbox-item-active' : '' }}"
               style="background: {{ $isActive ? 'rgba(220,165,62,0.1)' : 'rgba(255,255,255,0.03)' }}; border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;">
              {{-- Avatar --}}
              @php
                $other = $conv->other;
                $avatar = $other->avatar
                  ? (str_starts_with($other->avatar, 'http') ? $other->avatar : asset('storage/' . $other->avatar))
                  : 'https://ui-avatars.com/api/?name=' . urlencode($other->name) . '&background=dca53e&color=000&size=64&bold=true';
              @endphp
              <div style="position: relative; flex-shrink: 0;">
                <img src="{{ $avatar }}" alt="{{ $other->name }}"
                     style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(220,165,62,0.3);">
                @if($conv->unread > 0)
                  <span style="position: absolute; top: -3px; right: -3px; width: 14px; height: 14px; background: #dca53e; border-radius: 50%; border: 2px solid #0a0a0a;"></span>
                @endif
              </div>
              <div style="flex: 1; min-width: 0;">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <span style="font-weight: 700; color: {{ $conv->unread > 0 ? '#fff' : '#a1a1aa' }}; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px;">
                    {{ $other->name }}
                  </span>
                  <span style="font-size: 0.68rem; color: #52525b;">
                    {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '' }}
                  </span>
                </div>
                @if($conv->subject)
                  <div style="font-size: 0.72rem; color: #dca53e; font-weight: 600; margin-bottom: 2px;">{{ $conv->subject }}</div>
                @endif
                <div style="font-size: 0.75rem; color: #71717a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                  @if($conv->latestMessage)
                    {{ $conv->latestMessage->sender_id === Auth::id() ? 'Anda: ' : '' }}{{ Str::limit($conv->latestMessage->body, 45) }}
                  @else
                    <em>Belum ada pesan</em>
                  @endif
                </div>
              </div>
              @if($conv->unread > 0)
                <span style="flex-shrink:0; background: #dca53e; color: #000; font-size: 0.65rem; font-weight: 800; padding: 2px 7px; border-radius: 50px;">{{ $conv->unread }}</span>
              @endif
            </a>
          @empty
            <div class="p-4 text-center" style="color: #52525b; background: rgba(255,255,255,0.03);">
              <i class="bi bi-chat-square-text fs-2 mb-2 d-block" style="color: rgba(220,165,62,0.3);"></i>
              <div style="font-size: 0.82rem;">Belum ada percakapan.</div>
              <div style="font-size: 0.75rem; margin-top: 4px;">Mulai pesan baru untuk memulai!</div>
            </div>
          @endforelse
        </div>
      </div>

      {{-- ─── RIGHT: Placeholder (select a thread) ──────────────────────────── --}}
      <div class="col-lg-8 d-none d-lg-flex align-items-center justify-content-center"
           style="min-height: 450px; background: rgba(255,255,255,0.02); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06);">
        <div class="text-center">
          <i class="bi bi-envelope-open fs-1 mb-3 d-block" style="color: rgba(220,165,62,0.2);"></i>
          <p style="color: #52525b; font-size: 0.9rem;">Pilih percakapan untuk membacanya</p>
          <button class="btn btn-sm mt-2"
                  style="background: rgba(220,165,62,0.1); color: #dca53e; border: 1px solid rgba(220,165,62,0.3); border-radius: 8px;"
                  data-bs-toggle="modal" data-bs-target="#newMessageModal">
            <i class="bi bi-plus-circle me-1"></i>Mulai Percakapan
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ─── New Message Modal ──────────────────────────────────────────────────── --}}
<div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #18181b; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
      <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
        <h5 class="modal-title" id="newMessageModalLabel"
            style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; font-size: 1rem;">
          <i class="bi bi-pencil-square me-2" style="color: #dca53e;"></i>Pesan Baru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('mailbox.store') }}" method="POST">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label" style="color: #a1a1aa; font-size: 0.8rem; font-weight: 600;">Kepada</label>
            <select name="recipient_id" id="recipient_id" class="form-select" required
                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px;">
              <option value="">– Pilih Penerima –</option>
              @foreach($contacts as $contact)
                <option value="{{ $contact->id }}" style="background: #18181b;">
                  {{ $contact->name }} ({{ ucfirst($contact->role) }})
                </option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="color: #a1a1aa; font-size: 0.8rem; font-weight: 600;">Subjek (Opsional)</label>
            <input type="text" name="subject" class="form-control"
                   placeholder="mis. Pertanyaan booking, Jadwal, dll"
                   style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px;">
          </div>
          <div class="mb-1">
            <label class="form-label" style="color: #a1a1aa; font-size: 0.8rem; font-weight: 600;">Pesan</label>
            <textarea name="body" class="form-control" rows="4" required
                      placeholder="Tulis pesan Anda di sini..."
                      style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; resize: none;"></textarea>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.07);">
          <button type="button" class="btn btn-sm" style="color: #71717a;" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm"
                  style="background: linear-gradient(135deg, #dca53e, #f0c060); color: #000; font-weight: 800; border-radius: 8px; padding: 8px 20px; border: none;">
            <i class="bi bi-send-fill me-1"></i>Kirim
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.mailbox-item:hover { background: rgba(220,165,62,0.07) !important; }
.mailbox-item-active { border-left: 3px solid #dca53e !important; }
</style>
@endsection
