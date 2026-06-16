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

    // Function ini menyiapkan data awal yang dibutuhkan oleh class.
    // Biasanya dipakai agar data bisa langsung tersedia saat email, service, atau export dijalankan.
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

    // Function ini mengatur informasi dasar email seperti subjek.
    // Bagian ini menentukan bagaimana email dikenali oleh penerima.
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Jadwal Konseling Baru — {$this->namaSiswa} | TK Al-Istiqomah",
        );
    }

    // Function ini menentukan template email yang akan dipakai.
    // Data yang sudah disiapkan akan dikirim ke view email untuk ditampilkan.
    public function content(): Content
    {
        return new Content(
            view: 'emails.konseling_baru',
        );
    }
}
