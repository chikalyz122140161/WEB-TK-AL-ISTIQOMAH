@extends('layouts.app')

@section('title', 'Chat - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Chat dengan Orang Tua')

@push('styles')
<style>
    /* Chat layout: two-column  */
    .chat-wrap {
        display: flex;
        gap: 0;
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 10px;
        overflow: hidden;
        height: calc(100vh - 56px - 48px - 20px); /* viewport minus header, title, margin */
        min-height: 500px;
    }

    /* Left: contact list */
    .chat-list {
        width: 260px;
        flex-shrink: 0;
        border-right: 1px solid #3E272320;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .chat-list__header {
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 700;
        color: #c2410c;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 1px solid #3E272320;
        background: #fff7ed;
        flex-shrink: 0;
    }
    .chat-list__body {
        overflow-y: auto;
        flex: 1;
    }
    .chat-contact {
        display: flex;
        flex-direction: column;
        padding: 12px 16px;
        border-bottom: 1px solid #FFFDE7;
        cursor: pointer;
        transition: background .12s;
        text-decoration: none;
    }
    .chat-contact:hover  { background: #fff7ed; }
    .chat-contact.active { background: #3D9B72; }
    .chat-contact__name {
        font-size: 13px;
        font-weight: 700;
        color: #3E2723;
        margin-bottom: 2px;
    }
    .chat-contact.active .chat-contact__name { color: #fff; }
    .chat-contact__sub {
        font-size: 11px;
        color: #5D4037;
        margin-bottom: 2px;
    }
    .chat-contact.active .chat-contact__sub { color: rgba(255,255,255,0.7); }
    .chat-contact__preview {
        font-size: 12px;
        color: #5D4037;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .chat-contact.active .chat-contact__preview { color: rgba(255,255,255,0.6); }

    /*  Right: conversation */
    .chat-window {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .chat-window__header {
        padding: 13px 20px;
        border-bottom: 1px solid #3E272320;
        font-size: 14px;
        font-weight: 700;
        color: #c2410c;
        background: #fff7ed;
        flex-shrink: 0;
    }
    .chat-window__body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Bubble */
    .bubble-row {
        display: flex;
        align-items: flex-end;
        gap: 8px;
    }
    .bubble-row--in  { justify-content: flex-start; }
    .bubble-row--out { justify-content: flex-end; }

    .bubble {
        max-width: 60%;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.55;
        color: #3E2723;
        position: relative;
    }
    .bubble--in  {
        background: #FFFDE7;
        border-bottom-left-radius: 3px;
    }
    .bubble--out {
        background: #3D9B72;
        color: #fff;
        border-bottom-right-radius: 3px;
    }
    .bubble__time {
        display: block;
        font-size: 10px;
        margin-top: 5px;
        color: rgba(0,0,0,0.35);
        text-align: right;
    }
    .bubble--out .bubble__time { color: rgba(255,255,255,0.55); }

    /* Input bar  */
    .chat-input {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-top: 1px solid #3E272320;
        background: #fff;
        flex-shrink: 0;
    }
    .chat-input__field {
        flex: 1;
        height: 40px;
        padding: 0 14px;
        font-size: 13px;
        color: #3E2723;
        background: #FFFDE7;
        border: 1px solid #3E272330;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        transition: border-color .15s;
    }
    .chat-input__field:focus {
        border-color: #fb923c;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(251,146,60,.15);
    }
    .chat-input__field::placeholder { color: #5D4037; }
    .chat-input__send {
        height: 40px;
        padding: 0 20px;
        background: #3D9B72;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .3px;
        white-space: nowrap;
        transition: background .15s;
    }
    .chat-input__send:hover { background: #2E8B60; }
</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    <h2 style="margin:0 0 16px;font-size:20px;font-weight:700;color:#3E2723;text-transform:uppercase;letter-spacing:.5px;">
        Chat dengan Orang Tua
    </h2>

    <div class="chat-wrap">

        {{-- Left: contact list  --}}
        <div class="chat-list">
            <div class="chat-list__header">Daftar Chat</div>
            <div class="chat-list__body">
                @foreach ($kontak as $k)
                <a href="{{ route('guru.chat', ['kontak_id' => $k['id']]) }}"
                   class="chat-contact {{ $k['id'] == $aktifId ? 'active' : '' }}">
                    <div class="chat-contact__name">{{ $k['nama'] }}</div>
                    <div class="chat-contact__sub">Orang Tua {{ $k['anak'] }} &mdash; {{ $k['kelas'] }}</div>
                    <div class="chat-contact__preview">{{ $k['preview'] }}</div>
                </a>
                @endforeach
            </div>
        </div>

        {{--  Right: chat window  --}}
        <div class="chat-window">
            <div class="chat-window__header">
                {{ $aktif['nama'] }} (Orang Tua {{ $aktif['anak'] }} &mdash; {{ $aktif['kelas'] }})
            </div>

            <div class="chat-window__body" id="chatBody">
                @foreach ($pesan as $p)
                <div class="bubble-row bubble-row--{{ $p['dari'] === 'guru' ? 'out' : 'in' }}">
                    <div class="bubble bubble--{{ $p['dari'] === 'guru' ? 'out' : 'in' }}">
                        {{ $p['teks'] }}
                        <span class="bubble__time">{{ $p['waktu'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <form class="chat-input" method="POST" action="{{ route('guru.kirim_chat') }}">
                @csrf
                <input type="hidden" name="kontak_id" value="{{ $aktifId }}">
                <input
                    class="chat-input__field"
                    type="text"
                    name="pesan"
                    placeholder="[INPUT] Ketik pesan..."
                    autocomplete="off"
                    required
                >
                <button type="submit" class="chat-input__send">KIRIM</button>
            </form>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    // Auto-scroll to bottom of chat
    const body = document.getElementById('chatBody');
    if (body) body.scrollTop = body.scrollHeight;
</script>
@endpush
