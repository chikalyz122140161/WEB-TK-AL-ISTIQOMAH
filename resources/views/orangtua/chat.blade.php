@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Chat dengan Guru - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Chat dengan Guru')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

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
        width: 260px;
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
        font-size: 13px; font-weight: 700;
        color: #3E2723; text-transform: uppercase;
        letter-spacing: .5px; margin-bottom: 10px;
    }
    .cl__search {
        width: 100%; padding: 8px 12px;
        border: 1px solid #e5e7eb; border-radius: 8px;
        font-size: 12px; color: #3E2723; background: #f9fafb;
        outline: none; font-family: inherit; box-sizing: border-box;
    }
    .cl__search:focus { border-color: #4CAF82; background: #fff; }
    .cl__body { overflow-y: auto; flex: 1; }

    .ci {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer; transition: background .12s;
    }
    .ci:hover { background: #f0fdf4; }
    .ci.active { background: #ecfdf5; border-left: 3px solid #4CAF82; }
    .ci__avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82, #2E8B60);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 700; flex-shrink: 0;
    }
    .ci__body { flex: 1; min-width: 0; }
    .ci__name {
        font-size: 13px; font-weight: 700; color: #3E2723;
        margin-bottom: 1px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ci__role {
        font-size: 11px; color: #6b7280;
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
        border-bottom: 1px solid #f3f4f6; background: #fff;
        display: flex; align-items: center; gap: 12px; flex-shrink: 0;
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
    .cw__head-status {
        font-size: 11px; color: #4CAF82;
        display: flex; align-items: center; gap: 4px; margin-top: 1px;
    }
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
    .msg-date { text-align: center; margin: 10px 0; }
    .msg-date span {
        display: inline-block; padding: 3px 12px;
        background: #e5e7eb; border-radius: 99px;
        font-size: 11px; color: #6b7280;
    }

    /* Bubble */
    .br { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 6px; }
    .br--in  { justify-content: flex-start; }
    .br--out { justify-content: flex-end; }

    .br__av {
        width: 30px; height: 30px; border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82, #2E8B60);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
    }
    .br--out .br__av {
        background: linear-gradient(135deg, #FFF176, #e6db00);
        color: #3E2723;
    }

    .bubble {
        max-width: 65%; padding: 10px 14px;
        font-size: 13px; line-height: 1.55;
    }
    .bubble--in {
        background: #fff; color: #3E2723;
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
        display: block; font-size: 10px;
        margin-top: 4px; color: rgba(0,0,0,0.3); text-align: right;
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
        flex: 1; height: 42px; padding: 0 16px;
        font-size: 13px; color: #3E2723;
        background: #f3f4f6;
        border: 1.5px solid transparent;
        border-radius: 99px; outline: none; font-family: inherit;
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

    /* Active contact indicator */
    #activeId { display: none; }
</style>
@endpush

@section('content')

<div class="chat-wrap">

    {{-- Contact List --}}
    <div class="cl">
        <div class="cl__top">
            <div class="cl__title">Guru & Staf</div>
            <input type="text" class="cl__search" placeholder="Cari guru...">
        </div>
        <div class="cl__body">
            @php
            $guruList = [
                ['id'=>1, 'nama'=>'Bu Siti, S.Pd',  'role'=>'Guru Kelas TK A',   'unread'=>2, 'active'=>true],
                ['id'=>2, 'nama'=>'Pak Ahmad',       'role'=>'Guru BK',           'unread'=>0, 'active'=>false],
                ['id'=>3, 'nama'=>'Bu Rina',         'role'=>'Guru Agama',        'unread'=>0, 'active'=>false],
                ['id'=>4, 'nama'=>'Bu Dewi',         'role'=>'Guru Seni',         'unread'=>0, 'active'=>false],
            ];
            @endphp
            @foreach ($guruList as $g)
            <div class="ci {{ $g['active'] ? 'active' : '' }}" onclick="switchContact({{ $g['id'] }}, '{{ $g['nama'] }}', '{{ $g['role'] }}')">
                <div class="ci__avatar">{{ substr($g['nama'], 0, 1) }}</div>
                <div class="ci__body">
                    <div class="ci__name">{{ $g['nama'] }}</div>
                    <div class="ci__role">{{ $g['role'] }}</div>
                </div>
                @if($g['unread'] > 0)
                <div class="ci__badge">{{ $g['unread'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Chat Window --}}
    <div class="cw">
        <div class="cw__head">
            <div class="cw__head-av" id="headAv">S</div>
            <div class="cw__head-info">
                <div class="cw__head-name" id="headName">Bu Siti, S.Pd</div>
                <div class="cw__head-status" id="headRole">Guru Kelas TK A</div>
            </div>
        </div>

        <div class="cw__body" id="chatBody">
            <div class="msg-date"><span>Hari Ini</span></div>

            @forelse ($pesan ?? [] as $p)
            @php $isOut = $p['dari'] === 'orangtua'; @endphp
            <div class="br br--{{ $isOut ? 'out' : 'in' }}">
                @if(!$isOut)
                <div class="br__av">S</div>
                @endif
                <div class="bubble bubble--{{ $isOut ? 'out' : 'in' }}">
                    {{ $p['teks'] }}
                    <span class="bubble__time">{{ $p['waktu'] }}</span>
                </div>
                @if($isOut)
                <div class="br__av" style="order:1;">O</div>
                @endif
            </div>
            @empty
            {{-- Dummy conversation --}}
            <div class="br br--in">
                <div class="br__av">S</div>
                <div class="bubble bubble--in">
                    Selamat pagi, Ibu. Saya ingin menginformasikan bahwa Ahmad menunjukkan perkembangan yang baik minggu ini. Dia sudah mulai lebih aktif dalam kegiatan berkelompok.
                    <span class="bubble__time">09:15</span>
                </div>
            </div>
            <div class="br br--out">
                <div class="bubble bubble--out">
                    Selamat pagi Bu Siti. Terima kasih atas informasinya. Senang mendengar Ahmad sudah ada kemajuan. Apakah ada yang perlu kami perhatikan di rumah?
                    <span class="bubble__time">09:20</span>
                </div>
                <div class="br__av">I</div>
            </div>
            <div class="br br--in">
                <div class="br__av">S</div>
                <div class="bubble bubble--in">
                    Untuk aspek sosial-emosional, ada baiknya di rumah dibiasakan berbagi dengan saudara atau teman bermain. Ahmad masih perlu belajar untuk giliran saat bermain.
                    <span class="bubble__time">09:22</span>
                </div>
            </div>
            <div class="br br--out">
                <div class="bubble bubble--out">
                    Baik Bu, akan kami coba terapkan di rumah. Terima kasih banyak atas sarannya.
                    <span class="bubble__time">09:25</span>
                </div>
                <div class="br__av">I</div>
            </div>
            <div class="br br--in">
                <div class="br__av">S</div>
                <div class="bubble bubble--in">
                    Sama-sama, Bu. Jangan lupa minggu depan ada kegiatan outdoor. Mohon Ahmad dipersiapkan dengan membawa topi dan bekal makanan.
                    <span class="bubble__time">09:30</span>
                </div>
            </div>
            <div class="br br--in">
                <div class="br__av">S</div>
                <div class="bubble bubble--in">
                    Informasi lengkap sudah saya kirim melalui surat edaran kemarin. Mohon konfirmasinya ya Bu.
                    <span class="bubble__time">09:31</span>
                </div>
            </div>
            @endforelse
        </div>

        <form class="cw__foot" method="POST" action="{{ route('orangtua.kirim_chat') }}">
            @csrf
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
    const chatBody = document.getElementById('chatBody');
    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

    document.getElementById('msgInput')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });

    function switchContact(id, name, role) {
        document.querySelectorAll('.ci').forEach(el => el.classList.remove('active'));
        event.currentTarget.classList.add('active');
        document.getElementById('headAv').textContent  = name.charAt(0);
        document.getElementById('headName').textContent = name;
        document.getElementById('headRole').textContent = role;
    }
</script>
@endpush
