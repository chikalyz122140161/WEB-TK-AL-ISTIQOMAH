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

    // Function ini menyiapkan data awal yang dibutuhkan oleh class.
    // Biasanya dipakai agar data bisa langsung tersedia saat email, service, atau export dijalankan.
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

    // Function ini mengatur informasi dasar email seperti subjek.
    // Bagian ini menentukan bagaimana email dikenali oleh penerima.
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Laporan Perkembangan {$this->namaSiswa} — Minggu ke-{$this->mingguKe}",
        );
    }

    // Function ini menentukan template email yang akan dipakai.
    // Data yang sudah disiapkan akan dikirim ke view email untuk ditampilkan.
    public function content(): Content
    {
        return new Content(
            view: 'emails.perkembangan_siswa',
        );
    }
}
