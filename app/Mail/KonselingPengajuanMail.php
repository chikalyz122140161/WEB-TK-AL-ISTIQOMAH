<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonselingPengajuanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $namaGuru,
        public string $namaOrtu,
        public string $namaSiswa,
        public string $tanggal,
        public string $waktu,
        public string $topik,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pengajuan Konseling Baru dari {$this->namaOrtu} — TK Al-Istiqomah",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konseling_pengajuan',
        );
    }
}
