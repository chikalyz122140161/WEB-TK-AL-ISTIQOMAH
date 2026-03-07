# Dokumentasi Frontend Menu Orang Tua
## SISTEM BK TK AL-ISTIQOMAH

---

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Struktur File](#struktur-file)
3. [Halaman Dashboard](#halaman-dashboard)
4. [Halaman Report Mingguan](#halaman-report-mingguan)
5. [Halaman Grafik Perkembangan](#halaman-grafik-perkembangan)
6. [Halaman Chat dengan Guru](#halaman-chat-dengan-guru)
7. [Halaman Pengajuan Konseling](#halaman-pengajuan-konseling)
8. [Route Configuration](#route-configuration)
9. [Teknologi yang Digunakan](#teknologi-yang-digunakan)

---

## Pendahuluan

Modul Orang Tua adalah bagian dari Sistem BK TK AL-ISTIQOMAH yang dirancang untuk memberikan akses kepada orang tua/wali murid untuk memantau perkembangan anak mereka. Modul ini menyediakan berbagai fitur seperti melihat laporan perkembangan mingguan, grafik perkembangan, chat dengan guru, dan pengajuan jadwal konseling.

### Tujuan
- Memberikan transparansi perkembangan anak kepada orang tua
- Memudahkan komunikasi antara orang tua dan guru
- Menyediakan platform untuk pengajuan konseling

---

## Struktur File

```
resources/views/orangtua/
├── partials/
│   └── sidebar.blade.php      # Sidebar navigasi
├── dashboard.blade.php         # Halaman utama dashboard
├── report_mingguan.blade.php   # Laporan perkembangan mingguan
├── grafik.blade.php            # Grafik perkembangan anak
├── chat.blade.php              # Chat dengan guru
└── konseling.blade.php         # Pengajuan jadwal konseling
```

---

## Halaman Dashboard

**File:** `dashboard.blade.php`

### Deskripsi
Halaman utama yang menampilkan ringkasan informasi anak dan akses cepat ke fitur-fitur utama.

### Komponen Utama
1. **Child Profile Card** - Kartu profil anak yang menampilkan:
   - Foto/inisial nama anak
   - Nama anak
   - Kelas dan tahun ajaran
   - Statistik: Kehadiran bulan ini, Total report, Rata-rata nilai, Pesan baru

2. **Quick Actions** - Menu akses cepat ke:
   - Report Mingguan
   - Grafik Perkembangan
   - Chat dengan Guru
   - Ajukan Konseling

3. **Recent Activity** - Aktivitas terbaru terkait anak

### Variabel yang Diperlukan
```php
$student          // Object siswa (nama, kelas, tahun_ajaran)
$kehadiranBulanIni // Integer - jumlah kehadiran
$totalReport      // Integer - total report tersedia
$avgScore         // Float - rata-rata nilai
$pesanBaru        // Integer - jumlah pesan baru
```

---

## Halaman Report Mingguan

**File:** `report_mingguan.blade.php`

### Deskripsi
Menampilkan laporan perkembangan anak per minggu dengan 6 aspek penilaian sesuai kurikulum PAUD.

### Fitur Utama
1. **Week Selector** - Dropdown untuk memilih minggu
2. **Download PDF** - Tombol untuk mengunduh laporan dalam format PDF
3. **Report Card** - Kartu laporan dengan:
   - Header: Nama, Kelas, Periode
   - 6 Aspek Penilaian dengan skala 1-5:
     - Fisik-Motorik
     - Kognitif
     - Bahasa
     - Sosial-Emosional
     - Nilai Agama & Moral
     - Seni
   - Catatan guru per aspek
   - Catatan umum guru

4. **Navigation** - Tombol navigasi ke minggu sebelumnya/berikutnya

### Variabel yang Diperlukan
```php
$student          // Object siswa
$fisikMotorik     // Object dengan properti 'catatan' dan 'nilai'
$kognitif         // Object dengan properti 'catatan' dan 'nilai'
$bahasa           // Object dengan properti 'catatan' dan 'nilai'
$sosialEmosional  // Object dengan properti 'catatan' dan 'nilai'
$nilaiAgama       // Object dengan properti 'catatan' dan 'nilai'
$seni             // Object dengan properti 'catatan' dan 'nilai'
$catatanUmum      // String - catatan umum dari guru
```

---

## Halaman Grafik Perkembangan

**File:** `grafik.blade.php`

### Deskripsi
Visualisasi perkembangan anak dalam bentuk grafik untuk memudahkan analisis tren.

### Fitur Utama
1. **Filter Section** - Filter berdasarkan:
   - Periode (1 bulan, 3 bulan, 6 bulan, 1 tahun)
   - Aspek perkembangan

2. **Summary Cards** - 6 kartu ringkasan nilai rata-rata per aspek dengan indikator tren

3. **Line Chart** - Grafik garis perkembangan 6 aspek dari waktu ke waktu

4. **Radar Chart** - Grafik radar untuk melihat profil perkembangan keseluruhan

### Library yang Digunakan
- Chart.js (CDN: `https://cdn.jsdelivr.net/npm/chart.js`)

### Variabel yang Diperlukan
```php
// Data untuk charts dapat diambil dari controller
$chartData        // Array data untuk grafik
```

---

## Halaman Chat dengan Guru

**File:** `chat.blade.php`

### Deskripsi
Fitur chat real-time untuk komunikasi antara orang tua dan guru.

### Fitur Utama
1. **Contact List** - Daftar guru yang dapat dihubungi dengan:
   - Avatar
   - Nama guru
   - Role/jabatan
   - Badge notifikasi pesan belum dibaca

2. **Chat Area** - Area percakapan dengan:
   - Header: Info guru yang sedang diajak chat
   - Messages: Riwayat pesan dengan bubble style
   - Input: Field input pesan dan tombol kirim

### Komponen UI
- Message bubbles (sent/received)
- Date separators
- Online status indicator
- Real-time message preview

### JavaScript Functions
```javascript
sendMessage()     // Fungsi untuk mengirim pesan
// Event listener untuk Enter key
```

---

## Halaman Pengajuan Konseling

**File:** `konseling.blade.php`

### Deskripsi
Form untuk mengajukan jadwal konseling dengan guru BK.

### Fitur Utama
1. **Info Alert** - Informasi tentang jadwal dan proses konseling

2. **Form Pengajuan** dengan field:
   - Nama Anak (readonly)
   - Kelas (readonly)
   - Pilih Tanggal
   - Pilih Guru BK
   - Pilih Waktu (time slots)
   - Topik/Permasalahan (textarea)

3. **Time Slots** - Slot waktu dengan status:
   - Tersedia (dapat dipilih)
   - Tidak Tersedia (disabled)

4. **Riwayat Konseling** - Tabel riwayat pengajuan dengan status:
   - Menunggu (pending)
   - Disetujui (approved)
   - Selesai (completed)
   - Dibatalkan (cancelled)

### Variabel yang Diperlukan
```php
$student          // Object siswa
$guruList         // Array daftar guru BK
$availableSlots   // Array slot waktu tersedia
$historyKonseling // Array riwayat konseling
```

---

## Route Configuration

Tambahkan route berikut ke file `routes/web.php`:

```php
// Route untuk Orang Tua
Route::prefix('orangtua')->name('orangtua.')->middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/dashboard', [OrangtuaController::class, 'dashboard'])->name('dashboard');
    Route::get('/report-mingguan', [OrangtuaController::class, 'reportMingguan'])->name('report_mingguan');
    Route::get('/grafik', [OrangtuaController::class, 'grafik'])->name('grafik');
    Route::get('/chat', [OrangtuaController::class, 'chat'])->name('chat');
    Route::get('/konseling', [OrangtuaController::class, 'konseling'])->name('konseling');
    Route::post('/konseling', [OrangtuaController::class, 'storeKonseling'])->name('konseling.store');
});
```

---

## Teknologi yang Digunakan

### Frontend
- **Laravel Blade** - Template engine
- **CSS Custom** - Styling inline dengan design system yang konsisten
- **Chart.js** - Library untuk grafik/chart
- **Heroicons** - SVG icons

### Design System
Color Palette:
- Primary: `#faae2b` (Golden Yellow)
- Dark Teal: `#00473e` (Headlines)
- Paragraph: `#475d5b`
- Background: `#f2f7f5`
- Success: `#ECFDF5` / `#047857`
- Warning: `#FFFBEB` / `#B45309`
- Error: `#FEF2F2` / `#B91C1C`
- Info: `#EFF6FF` / `#1D4ED8`

### Typography
- Font Family: Inter
- Scales: 12px caption | 14px body | 16px body-lg | 20px title | 24px heading

### Spacing
- Kelipatan 8px: 4, 8, 12, 16, 24, 32, 40, 48, 56, 64

---

## Catatan Pengembangan

### TODO untuk Backend
1. Buat `OrangtuaController` dengan method sesuai route
2. Setup relasi antara User (orangtua) dan Student
3. Implementasi real-time chat menggunakan Laravel Broadcasting/Pusher
4. Buat sistem notifikasi untuk pengajuan konseling
5. Implementasi PDF export untuk report mingguan

### Responsive Design
Semua halaman sudah didesain responsive dengan breakpoints:
- Desktop: > 1024px
- Tablet: 768px - 1024px
- Mobile: < 768px

---

## Changelog

### v1.0.0 (7 Maret 2026)
- Initial release
- Implementasi Dashboard Orang Tua
- Implementasi Report Mingguan
- Implementasi Grafik Perkembangan
- Implementasi Chat dengan Guru
- Implementasi Pengajuan Konseling

---

**Dokumentasi ini dibuat untuk SISTEM BK TK AL-ISTIQOMAH**
