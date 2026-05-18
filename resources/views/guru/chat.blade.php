@extends('layouts.app')

@section('title', 'Chat - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Chat dengan Orang Tua')

@push('styles')
<style>
    .chat-wrap {
        display: flex;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        height: calc(100vh - 56px - 48px - 24px);
        min-height: 520px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    /* ── Contact list ── */
    .cl {
        width: 280px;
        flex-shrink: 0;
        border-right: 1px solid #f3f4f6;
        display: flex;
        flex-direction: column;
        background: #fafafa;
    }
    .cl__top {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
        background: #fff;
    }
    .cl__title {
        font-size: 13px;
        font-weight: 700;
        color: #3E2723;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .btn-new-chat {
        font-size: 11px;
        font-weight: 600;
        color: #4CAF82;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        border-radius: 6px;
        padding: 3px 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background .12s;
    }
    .btn-new-chat:hover { background: #d1fae5; }
    .cl__search {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 12px;
        color: #3E2723;
        background: #f9fafb;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
    }
    .cl__search:focus { border-color: #4CAF82; background: #fff; }
    .cl__body { overflow-y: auto; flex: 1; }

    .ci {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer;
        text-decoration: none;
        transition: background .12s;
        position: relative;
    }
    .ci:hover { background: #f0fdf4; }
    .ci.active { background: #ecfdf5; border-left: 3px solid #4CAF82; }
    .ci__avatar {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82, #2E8B60);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 700;
        flex-shrink: 0;
    }
    .ci.active .ci__avatar { background: linear-gradient(135deg, #3D9B72, #2E8B60); }
    .ci__body { flex: 1; min-width: 0; }
    .ci__name {
        font-size: 13px; font-weight: 700;
        color: #3E2723; margin-bottom: 1px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ci__sub {
        font-size: 11px; color: #6b7280;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ci__preview {
        font-size: 11px; color: #9ca3af;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-top: 2px;
    }
    .ci__time {
        font-size: 10px; color: #9ca3af;
        flex-shrink: 0; align-self: flex-start; margin-top: 2px;
    }

    /* ── Chat window ── */
    .cw { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

    .cw__head {
        padding: 12px 20px;
        border-bottom: 1px solid #f3f4f6;
        background: #fff;
        display: flex; align-items: center; gap: 12px;
        flex-shrink: 0;
    }
    .cw__head-av {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82, #2E8B60);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; flex-shrink: 0;
    }
    .cw__head-info { flex: 1; }
    .cw__head-name { font-size: 14px; font-weight: 700; color: #3E2723; }
    .cw__head-status { font-size: 11px; color: #6b7280; margin-top: 1px; }

    .cw__body {
        flex: 1; overflow-y: auto;
        padding: 20px;
        background: #f8faf9;
        display: flex; flex-direction: column; gap: 4px;
    }

    /* Empty state */
    .cw__empty {
        flex: 1;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        color: #9ca3af; gap: 10px;
    }
    .cw__empty svg { width: 48px; height: 48px; opacity: .35; }
    .cw__empty p { font-size: 13px; }

    /* Date separator */
    .msg-date { text-align: center; margin: 10px 0; }
    .msg-date span {
        display: inline-block;
        padding: 3px 12px;
        background: #e5e7eb; border-radius: 99px;
        font-size: 11px; color: #6b7280;
    }

    /* Bubble */
    .br { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 6px; }
    .br--in  { justify-content: flex-start; }
    .br--out { justify-content: flex-end; }

    .br__av {
        width: 30px; height: 30px; border-radius: 50%;
        background: linear-gradient(135deg, #FFF176, #e6db00);
        color: #3E2723;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
    }
    .br--out .br__av { background: linear-gradient(135deg, #4CAF82, #2E8B60); color: #fff; }

    .bubble {
        max-width: 62%;
        padding: 10px 14px;
        font-size: 13px; line-height: 1.55;
    }
    .bubble--in {
        background: #fff;
        color: #3E2723;
        border-radius: 14px 14px 14px 3px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .bubble--out {
        background: linear-gradient(135deg, #4CAF82, #2E8B60);
        color: #fff;
        border-radius: 14px 14px 3px 14px;
        box-shadow: 0 2px 6px rgba(61,155,114,0.25);
    }
    .bubble__time {
        display: block; font-size: 10px; margin-top: 4px;
        color: rgba(0,0,0,0.3); text-align: right;
    }
    .bubble--out .bubble__time { color: rgba(255,255,255,0.55); }

    /* Input */
    .cw__foot {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px;
        border-top: 1px solid #f3f4f6;
        background: #fff; flex-shrink: 0;
    }
    .cw__input {
        flex: 1; height: 42px;
        padding: 0 16px;
        font-size: 13px; color: #3E2723;
        background: #f3f4f6;
        border: 1.5px solid transparent;
        border-radius: 99px;
        outline: none; font-family: inherit;
        transition: all .15s;
    }
    .cw__input:focus {
        border-color: #4CAF82; background: #fff;
        box-shadow: 0 0 0 3px rgba(76,175,130,0.12);
    }
    .cw__input::placeholder { color: #9ca3af; }
    .cw__send {
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82, #2E8B60);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all .15s;
        box-shadow: 0 2px 6px rgba(61,155,114,0.3);
    }
    .cw__send:hover { transform: scale(1.07); box-shadow: 0 4px 12px rgba(61,155,114,0.4); }
    .cw__send:disabled { opacity: .45; cursor: not-allowed; transform: none; }
    .cw__send svg { width: 18px; height: 18px; fill: #fff; }

    /* ── New Chat Modal ── */
    #newChatModal .modal-box {
        width: 360px;
        max-height: 480px;
        max-width: 100%;
        padding: 0;
        display: flex; flex-direction: column;
        overflow: hidden;
    }
    .modal-head {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-head h3 { font-size: 14px; font-weight: 700; color: #3E2723; margin: 0; }
    .modal-close {
        width: 28px; height: 28px; border-radius: 50%;
        background: #f3f4f6; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; color: #6b7280; line-height: 1;
    }
    .modal-close:hover { background: #e5e7eb; }
    .modal-body { overflow-y: auto; flex: 1; }
    .modal-empty { padding: 32px; text-align: center; font-size: 13px; color: #9ca3af; }

    .ot-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer;
        transition: background .12s;
    }
    .ot-item:hover { background: #f0fdf4; }
    .ot-av {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, #FFF176, #e6db00);
        color: #3E2723;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; flex-shrink: 0;
    }
    .ot-name { font-size: 13px; font-weight: 600; color: #3E2723; flex: 1; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

<div class="chat-wrap">

    {{-- Contact List --}}
    <div class="cl">
        <div class="cl__top">
            <div class="cl__title">
                Percakapan
                <button class="btn-new-chat" id="btnNewChat">+ Chat Baru</button>
            </div>
            <input type="text" class="cl__search" id="clSearch" placeholder="Cari orang tua...">
        </div>
        <div class="cl__body" id="clBody">
            @forelse ($kontak as $k)
            <a href="{{ route('guru.chat', ['room' => $k['room_id']]) }}"
               class="ci {{ $k['room_id'] == $aktifId ? 'active' : '' }}"
               data-name="{{ strtolower($k['nama']) }}">
                <div class="ci__avatar">{{ $k['initial'] }}</div>
                <div class="ci__body">
                    <div class="ci__name">{{ $k['nama'] }}</div>
                    <div class="ci__sub">{{ $k['sub'] }}</div>
                    <div class="ci__preview">{{ $k['preview'] }}</div>
                </div>
                @if($k['waktu'])
                <div class="ci__time">{{ $k['waktu'] }}</div>
                @endif
            </a>
            @empty
            <div style="padding:24px;text-align:center;font-size:12px;color:#9ca3af;">Belum ada percakapan</div>
            @endforelse
        </div>
    </div>

    {{-- Chat Window --}}
    <div class="cw">
        @if ($aktif)
        {{-- Header --}}
        <div class="cw__head">
            <div class="cw__head-av">{{ $aktif['initial'] }}</div>
            <div class="cw__head-info">
                <div class="cw__head-name">{{ $aktif['nama'] }}</div>
                <div class="cw__head-status">{{ $aktif['sub'] }}</div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="cw__body" id="chatBody">
            @if(count($pesan) === 0)
            <div style="margin:auto;text-align:center;color:#9ca3af;font-size:12px;">
                Belum ada pesan. Mulai percakapan!
            </div>
            @else
            <div class="msg-date"><span>Percakapan</span></div>
            @foreach ($pesan as $p)
            <div class="br br--{{ $p['is_mine'] ? 'out' : 'in' }}">
                @if(!$p['is_mine'])
                <div class="br__av">{{ $p['initial'] }}</div>
                @endif
                <div class="bubble bubble--{{ $p['is_mine'] ? 'out' : 'in' }}">
                    {{ $p['teks'] }}
                    <span class="bubble__time">{{ $p['waktu'] }}</span>
                </div>
                @if($p['is_mine'])
                <div class="br__av">{{ strtoupper(mb_substr(auth()->user()->name ?? 'G', 0, 1)) }}</div>
                @endif
            </div>
            @endforeach
            @endif
        </div>

        {{-- Input --}}
        <form class="cw__foot" method="POST" action="{{ route('guru.kirim_chat') }}">
            @csrf
            <input type="hidden" name="room_id" value="{{ $aktifId }}">
            <input class="cw__input" type="text" name="pesan"
                   placeholder="Ketik pesan..." autocomplete="off" required id="msgInput">
            <button type="submit" class="cw__send">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z"/>
                </svg>
            </button>
        </form>

        @else
        {{-- Empty state --}}
        <div class="cw__empty">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
            </svg>
            <p>Pilih percakapan atau mulai chat baru</p>
            <button class="btn-new-chat" id="btnNewChat2" style="margin-top:4px;padding:6px 14px;font-size:12px;">+ Chat Baru</button>
        </div>
        @endif
    </div>

</div>

{{-- New Chat Modal --}}
<div class="modal-overlay" id="newChatModal">
    <div class="modal-box">
        <div class="modal-head">
            <h3>Mulai Chat Baru</h3>
            <button class="modal-close" id="modalClose">&times;</button>
        </div>
        <div style="padding:12px 16px;border-bottom:1px solid #f3f4f6;">
            <input type="text" id="modalSearch" placeholder="Cari pengguna..."
                   style="width:100%;padding:8px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:12px;font-family:inherit;outline:none;box-sizing:border-box;"
                   oninput="filterModal(this.value)">
        </div>
        <div class="modal-body" id="modalUserList">
            @if(count($orangtua) > 0)
            @foreach($orangtua as $ot)
            <form method="POST" action="{{ route('guru.open_chat_room') }}"
                  class="ot-form" data-name="{{ strtolower($ot['nama']) }}">
                @csrf
                <input type="hidden" name="target_user_id" value="{{ $ot['id'] }}">
                <button type="submit" class="ot-item" style="width:100%;text-align:left;background:none;border:none;font-family:inherit;">
                    <div class="ot-av">{{ $ot['initial'] }}</div>
                    <div style="flex:1;min-width:0;">
                        <div class="ot-name">{{ $ot['nama'] }}</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:1px;">{{ $ot['role'] }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </button>
            </form>
            @endforeach
            <div id="modalNoResult" style="display:none;padding:24px;text-align:center;font-size:12px;color:#9ca3af;">Tidak ada pengguna ditemukan</div>
            @else
            <div class="modal-empty">Semua pengguna sudah memiliki percakapan aktif</div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Scroll to bottom on load
    const body = document.getElementById('chatBody');
    if (body) body.scrollTop = body.scrollHeight;

    // Enter to send
    document.getElementById('msgInput')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });

    // New chat modal
    const modal = document.getElementById('newChatModal');
    function openModal() { modal.classList.add('active'); }
    function closeModal() { modal.classList.remove('active'); }

    document.getElementById('btnNewChat')?.addEventListener('click', openModal);
    document.getElementById('btnNewChat2')?.addEventListener('click', openModal);
    document.getElementById('modalClose')?.addEventListener('click', closeModal);
    modal?.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    // Contact search filter
    document.getElementById('clSearch')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#clBody .ci').forEach(el => {
            el.style.display = el.dataset.name?.includes(q) ? '' : 'none';
        });
    });

    // Modal user search
    function filterModal(q) {
        q = q.toLowerCase();
        const forms = document.querySelectorAll('#modalUserList .ot-form');
        let visible = 0;
        forms.forEach(f => {
            const match = f.dataset.name?.includes(q);
            f.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        const noResult = document.getElementById('modalNoResult');
        if (noResult) noResult.style.display = visible === 0 ? '' : 'none';
    }

    // Clear search when modal opens
    document.getElementById('btnNewChat')?.addEventListener('click', () => {
        const s = document.getElementById('modalSearch');
        if (s) { s.value = ''; filterModal(''); }
    });
    document.getElementById('btnNewChat2')?.addEventListener('click', () => {
        const s = document.getElementById('modalSearch');
        if (s) { s.value = ''; filterModal(''); }
    });
</script>
@endpush
