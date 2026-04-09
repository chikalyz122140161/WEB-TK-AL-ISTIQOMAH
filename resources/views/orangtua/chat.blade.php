@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Chat dengan Guru - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Chat dengan Guru')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

@push('styles')
<style>
    .chat-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 20px;
        height: calc(100vh - 180px);
        min-height: 500px;
    }
    @media (max-width: 900px) {
        .chat-container {
            grid-template-columns: 1fr;
            height: auto;
        }
    }

    /* Contact List */
    .contact-list {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .contact-list__header {
        padding: 16px;
        border-bottom: 1px solid #3E272310;
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
    }
    .contact-list__body {
        flex: 1;
        overflow-y: auto;
    }
    .contact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        cursor: pointer;
        border-bottom: 1px solid #3E272308;
        transition: all 0.2s;
    }
    .contact-item:hover {
        background: #f8f9fa;
    }
    .contact-item.active {
        background: linear-gradient(135deg, #4CAF8220 0%, #3D9B7220 100%);
        border-left: 3px solid #4CAF82;
    }
    .contact-item__avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .contact-item__info {
        flex: 1;
        min-width: 0;
    }
    .contact-item__name {
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 2px;
    }
    .contact-item__role {
        font-size: 12px;
        color: #5D4037;
    }
    .contact-item__badge {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #4CAF82;
        color: #3E2723;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Chat Area */
    .chat-area {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .chat-area__header {
        padding: 16px 20px;
        border-bottom: 1px solid #3E272310;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .chat-area__header-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
    }
    .chat-area__header-info {
        flex: 1;
    }
    .chat-area__header-name {
        font-size: 15px;
        font-weight: 600;
        color: #3E2723;
    }
    .chat-area__header-status {
        font-size: 12px;
        color: #10B981;
    }

    /* Messages */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }
    .message-date {
        text-align: center;
        margin: 16px 0;
    }
    .message-date span {
        display: inline-block;
        padding: 4px 12px;
        background: #3E272320;
        border-radius: 12px;
        font-size: 11px;
        color: #5D4037;
    }
    .message {
        display: flex;
        margin-bottom: 16px;
    }
    .message--sent {
        justify-content: flex-end;
    }
    .message__bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
    }
    .message--received .message__bubble {
        background: #fff;
        color: #3E2723;
        border: 1px solid #3E272310;
        border-bottom-left-radius: 4px;
    }
    .message--sent .message__bubble {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #3E2723;
        border-bottom-right-radius: 4px;
    }
    .message__time {
        font-size: 11px;
        color: #5D4037;
        margin-top: 4px;
    }
    .message--sent .message__time {
        text-align: right;
        color: #3E272399;
    }

    /* Chat Input */
    .chat-input {
        padding: 16px 20px;
        border-top: 1px solid #3E272310;
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .chat-input__field {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #3E272320;
        border-radius: 24px;
        font-size: 14px;
        color: #3E2723;
        background: #f8f9fa;
        resize: none;
        font-family: inherit;
    }
    .chat-input__field:focus {
        outline: none;
        border-color: #4CAF82;
        background: #fff;
    }
    .chat-input__field::placeholder {
        color: #5D4037;
    }
    .btn-send {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        flex-shrink: 0;
    }
    .btn-send:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(76,175,130, 0.4);
    }
    .btn-send svg {
        width: 20px;
        height: 20px;
        fill: #3E2723;
    }

    /* Empty State */
    .chat-empty {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #5D4037;
        padding: 40px;
    }
    .chat-empty svg {
        width: 80px;
        height: 80px;
        fill: #3E272330;
        margin-bottom: 16px;
    }
    .chat-empty__text {
        font-size: 14px;
        text-align: center;
    }
</style>
@endpush

<div class="chat-container">
    {{-- Contact List --}}
    <div class="contact-list">
        <div class="contact-list__header">
            Daftar Guru
        </div>
        <div class="contact-list__body">
            <div class="contact-item active">
                <div class="contact-item__avatar">S</div>
                <div class="contact-item__info">
                    <div class="contact-item__name">Bu Siti</div>
                    <div class="contact-item__role">Guru Kelas TK A</div>
                </div>
                <div class="contact-item__badge">2</div>
            </div>
            <div class="contact-item">
                <div class="contact-item__avatar">A</div>
                <div class="contact-item__info">
                    <div class="contact-item__name">Pak Ahmad</div>
                    <div class="contact-item__role">Guru BK</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-item__avatar">R</div>
                <div class="contact-item__info">
                    <div class="contact-item__name">Bu Rina</div>
                    <div class="contact-item__role">Guru Agama</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-item__avatar">D</div>
                <div class="contact-item__info">
                    <div class="contact-item__name">Bu Dewi</div>
                    <div class="contact-item__role">Guru Seni</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chat Area --}}
    <div class="chat-area">
        <div class="chat-area__header">
            <div class="chat-area__header-avatar">S</div>
            <div class="chat-area__header-info">
                <div class="chat-area__header-name">Bu Siti</div>
                <div class="chat-area__header-status">Online</div>
            </div>
        </div>

        <div class="chat-messages">
            <div class="message-date">
                <span>Hari Ini</span>
            </div>

            <div class="message message--received">
                <div>
                    <div class="message__bubble">
                        Selamat pagi, Ibu. Saya ingin menginformasikan bahwa Ahmad menunjukkan perkembangan yang baik minggu ini. Dia sudah mulai lebih aktif dalam kegiatan berkelompok.
                    </div>
                    <div class="message__time">09:15</div>
                </div>
            </div>

            <div class="message message--sent">
                <div>
                    <div class="message__bubble">
                        Selamat pagi Bu Siti. Terima kasih atas informasinya. Senang mendengar Ahmad sudah ada kemajuan. Apakah ada yang perlu kami perhatikan di rumah?
                    </div>
                    <div class="message__time">09:20</div>
                </div>
            </div>

            <div class="message message--received">
                <div>
                    <div class="message__bubble">
                        Untuk aspek sosial-emosional, ada baiknya di rumah dibiasakan berbagi dengan saudara atau teman bermain. 
Ahmad masih perlu belajar untuk giliran saat bermain.
                    </div>
                    <div class="message__time">09:22</div>
                </div>
            </div>

            <div class="message message--sent">
                <div>
                    <div class="message__bubble">
                        Baik Bu, akan kami coba terapkan di rumah. Terima kasih banyak atas sarannya.
                    </div>
                    <div class="message__time">09:25</div>
                </div>
            </div>

            <div class="message message--received">
                <div>
                    <div class="message__bubble">
                        Sama-sama, Bu. Jangan lupa minggu depan ada kegiatan outdoor. Mohon Ahmad dipersiapkan dengan membawa topi dan bekal makanan.
                    </div>
                    <div class="message__time">09:30</div>
                </div>
            </div>

            <div class="message message--received">
                <div>
                    <div class="message__bubble">
                        Informasi lengkap sudah saya kirim melalui surat edaran kemarin. Mohon konfirmasinya ya Bu.
                    </div>
                    <div class="message__time">09:31</div>
                </div>
            </div>
        </div>

        <div class="chat-input">
            <input type="text" class="chat-input__field" placeholder="Ketik pesan..." id="messageInput">
            <button class="btn-send" onclick="sendMessage()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z"/></svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        if (message) {
            // Logic to send message
            alert('Pesan terkirim: ' + message);
            input.value = '';
        }
    }

    // Send on Enter key
    document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
</script>
@endpush

@endsection
