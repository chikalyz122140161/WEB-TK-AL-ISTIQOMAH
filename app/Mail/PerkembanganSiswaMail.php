<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PerkembanganSiswaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $namaSiswa,
        public string $namaOrtu,
        public string $namaGuru,
        public string $namaKelas,
        public string $tahunAjaran,
        public string $semester,
        public int    $mingguKe,
        public string $tanggal,
        public array  $hasilPenilaian, // [['aspek' => ..., 'konseling' => ..., 'level' => ...]]
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Laporan Perkembangan {$this->namaSiswa} — Minggu ke-{$this->mingguKe}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.perkembangan_siswa',
        );
    }
}
