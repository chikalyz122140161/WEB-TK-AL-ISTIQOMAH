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
    }
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
    .ci__badge {
        min-width: 18px; height: 18px;
        background: #F06292; color: #fff;
        border-radius: 99px; font-size: 10px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        padding: 0 4px; flex-shrink: 0;
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
    .cw__head-status { font-size: 11px; color: #4CAF82; display: flex; align-items: center; gap: 4px; margin-top: 1px; }
    .cw__head-status::before {
        content: ''; width: 7px; height: 7px;
        background: #4CAF82; border-radius: 50%; display: inline-block;
    }

    .cw__body {
        flex: 1; overflow-y: auto;
        padding: 20px;
        background: #f8faf9;
        display: flex; flex-direction: column; gap: 4px;
    }

    /* Date separator */
    .msg-date {
        text-align: center; margin: 10px 0;
    }
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
    .cw__send svg { width: 18px; height: 18px; fill: #fff; }
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
            <div class="cl__title">Percakapan</div>
            <input type="text" class="cl__search" placeholder="Cari orang tua...">
        </div>
        <div class="cl__body">
            @foreach ($kontak as $k)
            <a href="{{ route('guru.chat', ['kontak_id' => $k['id']]) }}"
               class="ci {{ $k['id'] == $aktifId ? 'active' : '' }}">
                <div class="ci__avatar">{{ substr($k['nama'], 0, 1) }}</div>
                <div class="ci__body">
                    <div class="ci__name">{{ $k['nama'] }}</div>
                    <div class="ci__sub">Ortu {{ $k['anak'] }} · {{ $k['kelas'] }}</div>
                    <div class="ci__preview">{{ $k['preview'] }}</div>
                </div>
                @if(!empty($k['unread']))
                <div class="ci__badge">{{ $k['unread'] }}</div>
                @endif
            </a>
            @endforeach
        </div>
    </div>

    {{-- Chat Window --}}
    <div class="cw">
        <div class="cw__head">
            <div class="cw__head-av">{{ substr($aktif['nama'], 0, 1) }}</div>
            <div class="cw__head-info">
                <div class="cw__head-name">{{ $aktif['nama'] }}</div>
                <div class="cw__head-status">Online · Ortu {{ $aktif['anak'] }} — {{ $aktif['kelas'] }}</div>
            </div>
        </div>

        <div class="cw__body" id="chatBody">
            <div class="msg-date"><span>Hari Ini</span></div>
            @foreach ($pesan as $p)
            @php $isOut = $p['dari'] === 'guru'; @endphp
            <div class="br br--{{ $isOut ? 'out' : 'in' }}">
                @if(!$isOut)
                <div class="br__av">{{ substr($aktif['nama'], 0, 1) }}</div>
                @endif
                <div class="bubble bubble--{{ $isOut ? 'out' : 'in' }}">
                    {{ $p['teks'] }}
                    <span class="bubble__time">{{ $p['waktu'] }}</span>
                </div>
                @if($isOut)
                <div class="br__av">G</div>
                @endif
            </div>
            @endforeach
        </div>

        <form class="cw__foot" method="POST" action="{{ route('guru.kirim_chat') }}">
            @csrf
            <input type="hidden" name="kontak_id" value="{{ $aktifId }}">
            <input class="cw__input" type="text" name="pesan"
                   placeholder="Ketik pesan..." autocomplete="off" required id="msgInput">
            <button type="submit" class="cw__send">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z"/>
                </svg>
            </button>
        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
    const body = document.getElementById('chatBody');
    if (body) body.scrollTop = body.scrollHeight;

    document.getElementById('msgInput')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });
</script>
@endpush
