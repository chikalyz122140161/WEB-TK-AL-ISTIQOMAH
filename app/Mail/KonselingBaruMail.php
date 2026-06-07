<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonselingBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $namaOrtu,
        public string $namaSiswa,
        public string $namaGuru,
        public string $namaKelas,
        public string $tanggal,
        public string $waktu,
        public string $topik,
        public string $tipe, // 'per_siswa' atau 'per_kelas'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Jadwal Konseling Baru — {$this->namaSiswa} | TK Al-Istiqomah",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konseling_baru',
        );
    }
}
