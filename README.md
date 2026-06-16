# Sistem Informasi TK AL-ISTIQOMAH

Sistem Informasi Terpadu untuk Taman Kanak-Kanak AL-ISTIQOMAH yang dirancang untuk mengelola data siswa, pendaftaran, pembelajaran, penilaian, dan komunikasi antara sekolah dan orang tua.

## Deskripsi Sistem

Sistem ini adalah aplikasi web berbasis Laravel yang membantu mengelola seluruh operasional sekolah TK AL-ISTIQOMAH, mulai dari pendaftaran siswa baru, pengaturan kelas, penilaian pembelajaran, hingga distribusi rapor kepada orang tua.

## Fitur Utama

### 1. **Pendaftaran Siswa Baru**
- Form pendaftaran online untuk calon siswa
- Pengumpulan data lengkap siswa dan orang tua
- Upload dokumen pendaftaran (akta, kartu keluarga, dll)
- Tracking status pendaftaran
- Verifikasi admin terhadap pendaftaran

### 2. **Manajemen Data Siswa**
- Penyimpanan data lengkap siswa (biodata, kesehatan, keluarga)
- Data orang tua/wali (ayah, ibu, wali)
- Riwayat kelas siswa
- Dokumen dan file siswa

### 3. **Pengaturan Kelas & Pembelajaran**
- Pengelolaan kelas dan tahun ajaran
- Daftar siswa per kelas
- Pengaturan mata pelajaran per kelas
- Pengaturan ekstrakurikuler per kelas
- Pengaturan konseling/BK per kelas

### 4. **Penilaian & Rapor**
- Pencatatan presensi siswa
- Penilaian mata pelajaran dengan dokumentasi foto
- Penilaian ekstrakurikuler
- Penilaian konseling/BK dengan aspek-aspek perkembangan
- Pembuatan rapor semester otomatis
- Pembuatan rapor perkembangan siswa

### 5. **Konseling Pribadi**
- Penjadwalan konseling pribadi antara siswa dan guru BK
- Pencatatan topik konseling
- Tracking status konseling
- Pelacakan asal permohonan konseling (guru atau orang tua)

### 6. **Komunikasi & Notifikasi**
- Sistem notifikasi untuk pengguna
- Jadwal kegiatan sekolah
- Chat dan messaging antar pengguna

## Komponen Sistem

### User & Akun
- **User** - Akun login dengan role (admin, guru, orang tua, siswa)

### Data Dasar
- **Student** - Data siswa
- **Parents** - Data orang tua/wali
- **StudentFile** - Dokumen/file siswa
- **StudentEnrollment** - Pendaftaran siswa di kelas tertentu
- **Registration** - Data pendaftaran calon siswa baru
- **DokumenPendaftaran** - Dokumen yang diupload saat pendaftaran

### Pengaturan Pembelajaran
- **AcademicTerm** - Tahun ajaran dan semester
- **Classroom** - Data kelas
- **ClassTerm** - Gabungan kelas dengan tahun ajaran
- **ClassTermSubject** - Mata pelajaran di kelas tertentu
- **ClassTermExtracurricular** - Ekstrakurikuler di kelas tertentu
- **ClassTermCounseling** - Konseling/BK di kelas tertentu

### Jadwal
- **ClassSchedule** - Jadwal pelajaran rutin
- **ActivitySchedule** - Jadwal kegiatan/acara sekolah
- **Schedule** - Jadwal umum siswa dan guru
- **PrivateCounselingSchedule** - Jadwal konseling pribadi

### Kehadiran
- **Presence** - Data presensi/kehadiran siswa

### Pembelajaran
- **Subject** - Mata pelajaran
- **Extracurricular** - Jenis ekstrakurikuler
- **ExtracurricularAssessment** - Aspek penilaian ekstrakurikuler
- **Counseling** - Jenis konseling/BK
- **CounselingAssessment** - Aspek penilaian konseling

### Rapor & Penilaian
- **Report** - Rapor siswa per semester
- **ReportSubject** - Nilai mata pelajaran di rapor
- **ReportSubjectImage** - Foto/bukti pembelajaran di rapor
- **ReportExtracurricular** - Nilai ekstrakurikuler di rapor
- **ReportExtracurricularScore** - Skor detail ekstrakurikuler
- **ReportCounseling** - Nilai konseling/BK di rapor
- **ReportCounselingScore** - Skor detail konseling
- **SemesterReport** - Rapor perkembangan siswa (PAUD/TK)

### Komunikasi
- **Notification** - Notifikasi untuk pengguna
- **Chat** - Percakapan antara pengguna
- **ChatRoom** - Ruang chat
- **ChatMessage** - Pesan dalam chat

## Alur Kerja Sistem

### 1. Pendaftaran
```
Calon Siswa → Isi Form Registrasi → Upload Dokumen → Admin Verifikasi → Diterima
```

### 2. Pembelajaran
```
Tahun Ajaran → Buat Kelas → Tentukan Mapel, Ekskul, BK → Daftar Siswa → Mulai Pembelajaran
```

### 3. Penilaian
```
Guru Input Presensi → Guru Input Nilai Mapel → Guru Input Nilai Ekskul → Guru Input Nilai BK → Rapor Terbentuk
```

### 4. Distribusi Rapor
```
Sistem Buat Rapor → Orang Tua Lihat di Aplikasi → Orang Tua Download/Print
```

## Teknologi yang Digunakan

- **Backend**: Laravel (PHP Framework)
- **Database**: MySQL/MariaDB
- **Frontend**: HTML, CSS, JavaScript, Blade Templating
- **Build Tool**: Vite



## Role & Hak Akses

- **Admin** - Mengelola semua data sistem, verifikasi pendaftaran
- **Guru** - Input nilai, absensi, jadwal, konseling
- **Orang Tua** - Lihat rapor anak, lihat jadwal, komunikasi dengan guru
- **Siswa** - Lihat rapor, lihat jadwal

## Kontak & Support

TK AL-ISTIQOMAH  
Untuk pertanyaan teknis, hubungi tim pengembang sistem.
