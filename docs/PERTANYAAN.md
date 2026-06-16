# Daftar Pertanyaan yang Mungkin Muncul di Sidang
## Sistem Informasi TK AL-ISTIQOMAH

---

## 1. PERTANYAAN UMUM TENTANG SISTEM

### Q: Sebutkan tujuan utama pembuatan sistem ini!
**A:** Sistem ini bertujuan untuk mengotomatisasi dan mengelola seluruh operasional TK AL-ISTIQOMAH, mulai dari pendaftaran siswa baru, pengaturan kelas, proses pembelajaran, penilaian siswa, hingga pembuatan dan distribusi rapor kepada orang tua secara terpusat dan efisien.

### Q: Siapa saja pengguna/stakeholder dari sistem ini?
**A:** Pengguna sistem ini terdiri dari: Admin (mengelola sistem), Guru (input nilai dan presensi), Orang Tua (melihat rapor dan jadwal), dan Siswa (melihat data pembelajaran mereka).

### Q: Apa keuntungan sistem ini dibanding sistem manual?
**A:** Keuntungannya adalah: (1) Data tersimpan aman dan terorganisir, (2) Proses lebih cepat dan efisien, (3) Orang tua bisa akses rapor kapan saja, (4) Mengurangi kesalahan input data, (5) Laporan otomatis terbentuk, (6) Komunikasi guru-orang tua lebih mudah.

### Q: Apa masalah yang ingin diselesaikan sistem ini?
**A:** Masalah yang ingin diselesaikan adalah: (1) Pengelolaan data siswa yang tidak terstruktur, (2) Proses penilaian manual yang memakan waktu, (3) Kesulitan distribusi rapor kepada orang tua, (4) Komunikasi antara guru dan orang tua kurang efektif, (5) Arsip dokumen pendaftaran tidak aman.

---

## 2. PERTANYAAN TENTANG ARSITEKTUR SISTEM

### Q: Jelaskan struktur database sistem ini!
**A:** Database terdiri dari beberapa kategori:
- **User & Autentikasi**: User, notification
- **Data Siswa**: Student, Parents, StudentFile, Registration
- **Pembelajaran**: Subject, Extracurricular, Counseling dan assessment-nya
- **Organisasi Kelas**: Classroom, ClassTerm, ClassTermSubject, ClassTermExtracurricular, ClassTermCounseling
- **Enrollment**: StudentEnrollment, Presence
- **Rapor**: Report, ReportSubject, ReportExtracurricular, ReportCounseling dan score-nya
- **Jadwal**: Schedule, ClassSchedule, ActivitySchedule, PrivateCounselingSchedule
- **Komunikasi**: Chat, ChatRoom, ChatMessage

### Q: Jelaskan relasi antara ClassTerm, StudentEnrollment, dan Report!
**A:** ClassTerm adalah kombinasi kelas dengan tahun ajaran/semester. StudentEnrollment menghubungkan siswa ke ClassTerm tertentu (siswa berada di kelas berapa pada semester berapa). Report adalah rapor siswa yang dihasilkan dari satu enrollment, berisi nilai dari berbagai aspek pembelajaran.

### Q: Mengapa perlu ada tabel ClassTermSubject, ClassTermExtracurricular, dan ClassTermCounseling?
**A:** Karena setiap tahun ajaran, mata pelajaran, ekstrakurikuler, dan konseling yang diajarkan bisa berbeda. Tabel-tabel ini menentukan apa saja yang akan diajarkan di kelas tertentu pada tahun ajaran tertentu, sehingga fleksibel dan terstruktur.

### Q: Apa bedanya Report dan SemesterReport?
**A:** Report adalah rapor yang detail untuk jenjang yang lebih tinggi (SD ke atas) dengan nilai per mata pelajaran, ekstrakurikuler, dan konseling. SemesterReport adalah rapor perkembangan siswa untuk jenjang PAUD/TK dengan penilaian aspek perkembangan (agama-moral, fisik-motorik, kognitif, bahasa, sosial-emosional, seni) dan deskripsi.

### Q: Mengapa ada field status, aksi, dan class_term_tujuan_id di tabel StudentEnrollment?
**A:** Field-field ini untuk mencatat perubahan status siswa: status (aktif/suspend), aksi (naik kelas/pindah/tinggal kelas), dan class_term_tujuan_id untuk mencatat siswa pindah ke kelas mana. Ini penting untuk tracking riwayat siswa.

---

## 3. PERTANYAAN TENTANG FITUR SISTEM

### Q: Jelaskan alur proses pendaftaran siswa baru!
**A:** (1) Calon siswa mengisi form Registration online dengan data lengkap diri dan orang tua, (2) Calon siswa upload dokumen pendaftaran via DokumenPendaftaran, (3) Admin menerima dan memverifikasi data, (4) Admin ubah status registration menjadi "diterima" atau "ditolak", (5) Jika diterima, admin membuat User dan Student dari data registration.

### Q: Bagaimana sistem menangani penilaian siswa yang terdiri dari mata pelajaran, ekstrakurikuler, dan konseling?
**A:** Sistem membuat tiga jalur penilaian terpisah:
- **Mata Pelajaran**: Report → ReportSubject → ReportSubjectImage (dengan dokumentasi foto)
- **Ekstrakurikuler**: Report → ReportExtracurricular → ReportExtracurricularScore (dengan aspek penilaian)
- **Konseling**: Report → ReportCounseling → ReportCounselingScore (dengan aspek penilaian per minggu)

### Q: Jelaskan bagaimana sistem mencatat presensi siswa!
**A:** Guru mencatat presensi via tabel Presence dengan field: student_enrollment_id (siswa di enrollment mana), date (tanggal), attendance (status: hadir/izin/sakit/alpa), dan description (keterangan). Sistem dapat menghitung total hadir, izin, sakit, alpa otomatis.

### Q: Bagaimana cara orang tua melihat rapor anak mereka?
**A:** Orang tua login dengan User mereka, sistem akan menampilkan Student yang terkait, kemudian orang tua bisa akses Report dan SemesterReport siswa tersebut. Mereka bisa melihat nilai per mata pelajaran, ekstrakurikuler, konseling, dan presensi.

### Q: Apa fungsi PrivateCounselingSchedule dalam sistem?
**A:** Untuk mencatat jadwal konseling pribadi antara siswa dan guru BK. Bisa dibuat oleh guru atau diminta oleh orang tua. Sistem mencatat: siswa, guru, tanggal/waktu, topik, status, dan sumbernya. Penting untuk tracking perkembangan emosional siswa.

### Q: Bagaimana sistem menangani chat atau komunikasi antara guru dan orang tua?
**A:** Menggunakan tabel Chat, ChatRoom, dan ChatMessage. ChatRoom adalah ruang percakapan antara satu guru dan satu orang tua (atau grup). ChatMessage adalah pesan individual dalam room tersebut. Sistem menyimpan history percakapan untuk referensi di kemudian hari.

---

## 4. PERTANYAAN TENTANG MODEL & RELASI

### Q: Jelaskan penerapan konsep One-to-Many (1:M) dalam sistem ini!
**A:** Contohnya:
- Satu Classroom bisa punya banyak ClassTerm (satu kelas bisa ada di banyak tahun ajaran)
- Satu Student bisa punya banyak StudentEnrollment (siswa bisa naik kelas setiap tahun)
- Satu Report bisa punya banyak ReportSubject (satu rapor berisi banyak mata pelajaran)

### Q: Jelaskan penerapan konsep Many-to-Many (M:M) dalam sistem ini!
**A:** Contohnya:
- ClassTerm dengan Subject melalui tabel junction ClassTermSubject (satu kelas banyak mata pelajaran, satu mata pelajaran banyak kelas)
- ClassTerm dengan Extracurricular melalui tabel junction ClassTermExtracurricular
- ClassTerm dengan Counseling melalui tabel junction ClassTermCounseling

### Q: Apa keuntungan menggunakan UUID sebagai primary key dibanding auto-increment integer?
**A:** Keuntungan UUID: (1) Unik secara global dan tidak mudah diprediksi (lebih aman), (2) Bisa generate di aplikasi sebelum insert (lebih fleksibel), (3) Cocok untuk sistem terdistribusi, (4) Tidak bergantung pada urutan database.

### Q: Apa fungsi SoftDeletes dalam sistem ini?
**A:** SoftDeletes membuat data tidak benar-benar dihapus dari database, hanya ditandai sebagai deleted (via deleted_at timestamp). Keuntungannya: (1) Data aman, bisa restore jika diperlukan, (2) Integritas relasi terjaga, (3) Audit trail tetap tersedia.

---

## 5. PERTANYAAN TENTANG TEKNOLOGI

### Q: Mengapa menggunakan Laravel sebagai framework?
**A:** Laravel dipilih karena: (1) Framework PHP yang powerful dan mudah dipelajari, (2) Built-in ORM (Eloquent) untuk database query, (3) Built-in authentication dan authorization, (4) Migrasi database yang mudah, (5) Ecosystem yang kaya dengan package, (6) Community yang besar.

### Q: Apa keuntungan menggunakan Eloquent ORM?
**A:** Keuntungan Eloquent: (1) Query lebih readable dan maintainable, (2) Relationship handling otomatis, (3) Proteksi SQL injection, (4) Type casting otomatis, (5) Soft delete support, (6) Pagination built-in.

### Q: Apa perbedaan protected $fillable dan protected $casts?
**A:** 
- **$fillable**: Menentukan field mana saja yang boleh mass-assign dari input (form). Untuk keamanan, mencegah hacker assign field yang tidak seharusnya.
- **$casts**: Menentukan tipe data field untuk konversi otomatis saat read/write dari database (date, integer, boolean, hashed password, dll).

### Q: Mengapa perlu protected $hidden?
**A:** Untuk menyembunyikan field tertentu saat model di-serialize menjadi JSON/array. Contohnya password dan remember_token tidak perlu tampil saat response API untuk keamanan.

---

## 6. PERTANYAAN TENTANG FITUR LANJUTAN

### Q: Bagaimana sistem menentukan siswa naik kelas atau tinggal kelas?
**A:** Proses ini manual diinput guru/admin di StudentEnrollment dengan field aksi. Guru tentukan: apakah siswa naik (normal), tinggal (repeat), atau pindah sekolah. System mencatat di class_term_tujuan_id kemana siswa pindah, sehingga riwayat siswa ter-track.

### Q: Bagaimana sistem memberikan nilai untuk aspek-aspek khusus (seperti "Kedisiplinan" di Konseling)?
**A:** (1) Admin setup jenis Konseling (misal: "Konseling Perilaku"), (2) Admin setup Aspek di CounselingAssessment (misal: "Kedisiplinan", "Kejujuran"), (3) Guru input nilai untuk setiap aspek di ReportCounselingScore per minggu, (4) Sistem menampilkan skor keseluruhan per aspek.

### Q: Bagaimana sistem menampilkan nilai dalam format yang user-friendly (bukan kode)?
**A:** Sistem gunakan function static seperti `getNilaiLabel()` untuk convert kode (BB, MB, BSH, BSB) menjadi label panjang. Ada juga `getNilaiColor()` untuk assign warna berbeda per level nilai agar visual lebih jelas saat ditampilkan di UI.

### Q: Bagaimana sistem menangani berbagai kategori orang tua (ayah, ibu, wali) di Parents?
**A:** Tabel Parents punya field category yang mencatat apakah itu ayah, ibu, atau wali. Satu siswa bisa punya multiple Parents record (ayah + ibu + wali) dengan category berbeda. Sistem bisa query based on category jika perlu komunikasi specific.

### Q: Bagaimana sistem menangani file upload (dokumen pendaftaran, foto pembelajaran)?
**A:** 
- **DokumenPendaftaran**: Menyimpan dokumen yang diupload saat pendaftaran dengan field path (lokasi file di server)
- **ReportSubjectImage**: Menyimpan foto pembelajaran dengan field path, guru bisa add description
- **StudentFile**: Menyimpan dokumen siswa dengan field type dan path

Sistem harus punya storage folder yang aman dan backup berkala.

---

## 7. PERTANYAAN TENTANG KEAMANAN & VALIDASI

### Q: Bagaimana sistem menjaga keamanan data siswa?
**A:** (1) Authentication via User login, (2) Authorization via role (admin/guru/ortu/siswa), (3) Password hashing menggunakan function hashed di Eloquent, (4) Form validation untuk input, (5) SQL injection protection via Eloquent, (6) Soft delete untuk data yang dihapus, (7) Audit trail melalui timestamp.

### Q: Bagaimana sistem memastikan hanya orang tua dari siswa tertentu yang bisa akses rapor siswa itu?
**A:** Sistem harus implement authorization logic: cek apakah User yang login adalah Parents dari Student tertentu sebelum allow akses Report. Bisa via middleware atau policy. Ini penting untuk privacy.

### Q: Apa validasi yang perlu dilakukan saat input presensi?
**A:** (1) student_enrollment_id harus valid (siswa terdaftar di kelas), (2) date tidak boleh di masa depan, (3) attendance harus salah satu dari enum (hadir/izin/sakit/alpa), (4) tidak boleh double entry satu siswa satu hari.

### Q: Bagaimana sistem handle jika siswa belum punya rapor?
**A:** Sistem harus cek apakah siswa punya Report. Jika belum, tampilkan message "Rapor belum tersedia". Admin/guru perlu selesaikan entry nilai dulu sebelum rapor bisa di-generate.

---

## 8. PERTANYAAN TENTANG IMPROVEMENT & FUTURE

### Q: Apa limitasi sistem saat ini?
**A:** (1) Belum ada fitur upload nilai massal (bulk upload), (2) Belum ada automated reminder notifikasi, (3) Belum ada export rapor ke PDF otomatis, (4) Chat masih basic (belum ada file sharing), (5) Belum ada analytics/dashboard reporting untuk admin.

### Q: Apa improvement yang bisa dilakukan di masa depan?
**A:** (1) Implementasi API untuk mobile app, (2) Automated email reminder untuk orang tua, (3) Export rapor ke PDF dengan design template, (4) Mobile app untuk guru dan orang tua, (5) Analytics dashboard untuk tracking performa kelas, (6) Integration dengan WhatsApp Business API, (7) Fitur parent-teacher meeting scheduling.

### Q: Bagaimana skalabilitas sistem jika siswa/data bertambah banyak?
**A:** (1) Database indexing pada field yang sering di-query, (2) Pagination untuk list yang banyak, (3) Cache untuk data yang jarang berubah, (4) Upgrade server resources jika perlu, (5) Consider database replication untuk backup, (6) Archive old data ke table terpisah.

### Q: Bagaimana sistem terintegrasi dengan sistem informasi sekolah lain jika ada?
**A:** Via REST API yang expose endpoint untuk: get student data, get report, post presence, post counseling. Sistem lain bisa consume API ini. Perlu implement API authentication (OAuth2 atau API Key) untuk keamanan.

---

## 9. PERTANYAAN TENTANG USE CASE

### Q: Jelaskan use case guru mengisi nilai mata pelajaran!
**A:** (1) Guru login, (2) Pilih kelas dan semester, (3) Lihat daftar siswa di kelas, (4) Untuk setiap siswa, input nilai dan deskripsi, (5) Upload foto pembelajaran sebagai bukti, (6) Save/submit nilai, (7) Sistem auto-create ReportSubject dan ReportSubjectImage.

### Q: Jelaskan use case orang tua mengakses rapor anak!
**A:** (1) Orang tua login dengan email dan password, (2) Sistem cek role orang tua dan link ke student, (3) Tampil list anak-anak yang terdaftar, (4) Orang tua pilih satu anak, (5) Tampil rapor semseter terbaru, (6) Orang tua bisa lihat nilai mata pelajaran, ekskul, konseling, presensi, (7) Orang tua bisa download/print rapor.

### Q: Jelaskan use case admin memproses pendaftaran siswa baru!
**A:** (1) Admin login, (2) Lihat list pendaftaran baru dengan status pending, (3) Buka detail registration, lihat data dan dokumen yang diupload, (4) Jika lengkap dan sesuai: ubah status menjadi "Diterima" dan create User & Student, (5) Jika tidak lengkap/ada masalah: ubah status "Ditolak" + catatan alasan, (6) Email notifikasi kirim ke email yang didaftar.

---

## 10. PERTANYAAN TENTANG DOKUMENTASI & DEPLOYMENT

### Q: Di mana dokumentasi sistem tersedia?
**A:** (1) README.md berisi overview dan cara menjalankan, (2) Kode model punya comment penjelasan setiap function, (3) Migration files menunjukkan struktur database, (4) API documentation (jika ada) di folder docs/, (5) PERTANYAAN.md ini untuk Q&A.

### Q: Bagaimana cara deploy sistem ke production?
**A:** (1) Setup server dengan PHP 8+, MySQL, Composer, Node.js, (2) Clone repo ke server, (3) Setup .env file dengan config production, (4) Run composer install, npm install, (5) Run php artisan migrate, (6) Setup web server (Apache/Nginx), (7) Setup SSL certificate, (8) Configure backups, (9) Setup monitoring.

### Q: Bagaimana backup data sistem?
**A:** (1) Database backup daily via cron job (mysqldump), (2) Upload file uploads (documents, photos) ke cloud storage, (3) Version control di Git, (4) Keep backup history 30 hari terakhir, (5) Test restore backup berkala.

---

## 11. PERTANYAAN KUALITATIF

### Q: Mengapa penting sistem informasi di sekolah TK?
**A:** Karena TK adalah tahap awal pendidikan dimana monitoring perkembangan sangat penting. Sistem membantu: (1) Guru track perkembangan siswa terstruktur, (2) Orang tua informed tentang progress anak, (3) Sekolah punya data digital yang aman, (4) Komunikasi guru-ortu lebih efektif.

### Q: Bagaimana sistem ini membantu guru?
**A:** (1) Input data jadi lebih mudah (tidak perlu manual tulis laporan), (2) Track siswa berdasarkan data history, (3) Identifikasi siswa yang perlu attention khusus, (4) Otomatis generate rapor, (5) Komunikasi dengan orang tua lebih terstruktur.

### Q: Apa kontribusi sistem terhadap peningkatan kualitas pendidikan?
**A:** (1) Data yang akurat membantu decision making yang lebih baik, (2) Monitoring perkembangan siswa lebih terstruktur, (3) Komunikasi guru-ortu lebih baik → parental involvement meningkat, (4) Early detection untuk siswa yang bermasalah, (5) Transparansi penuh dari sekolah ke orang tua.

---

## Tips Menghadapi Sidang

1. **Pahami arsitektur database** - Pastikan bisa jelaskan relasi antar tabel dengan lancar
2. **Siapkan demo sistem** - Tunjukkan fitur-fitur utama berjalan (pendaftaran, input nilai, akses rapor)
3. **Siapkan use case diagram** - Visualisasi alur proses user akan memudahkan penjelasan
4. **Siapkan ER diagram** - Gambaran database akan jelas untuk diskusi teknis
5. **Fahami code Anda** - Jika ditanya detail kode, harus bisa jelaskan dengan yakin
6. **Siapkan statistik/data** - Jika ada, tunjukkan testing data/metrics
7. **Siapkan limitations & future works** - Jujur tentang apa yang belum dicapai
8. **Praktek presentasi** - Presentasi yang lancar meninggalkan kesan positif
9. **Siapkan jawaban terbuka** - Ada kemungkinan pertanyaan di luar ini, siapkan logic reasoning
10. **Percaya diri** - Sistem Anda menggunakan teknologi yang tepat dan desain yang solid!

---

**Good Luck untuk sidang! 💪**
