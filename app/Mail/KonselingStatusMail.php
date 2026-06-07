<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonselingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $namaOrtu,
        public string $namaSiswa,
        public string $namaGuru,
        public string $tanggal,
        public string $waktu,
        public string $topik,
        public string $status, // 'disetujui' atau 'ditolak'
    ) {}

    public function envelope(): Envelope
    {
        $label = $this->status === 'disetujui' ? 'Disetujui ✓' : 'Ditolak ✗';
        return new Envelope(
            subject: "Jadwal Konseling {$label} — TK Al-Istiqomah",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konseling_status',
        );
    }
}
