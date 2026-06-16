# Panduan Belajar Sidang - Web TK Al-Istiqomah

Dokumen ini dibuat untuk membantu menjelaskan project secara sederhana saat sidang akhir. Anggap file ini sebagai "peta besar" aplikasi: apa tujuan aplikasinya, siapa penggunanya, bagian kode mana yang mengatur fitur tertentu, dan bagaimana data mengalir dari halaman ke database.

## 1. Ringkasan Project

Project ini adalah aplikasi web berbasis Laravel untuk membantu pengelolaan administrasi TK Al-Istiqomah.

Fitur besarnya:

- Pendaftaran siswa baru secara online.
- Login berdasarkan peran pengguna: admin, guru, dan orang tua.
- Admin mengelola data master seperti pengguna, siswa, kelas, tahun ajaran, mata pelajaran, ekstrakurikuler, konseling, DAPODIK, kenaikan siswa, dan backup database.
- Guru mengelola presensi, jadwal, konseling, chat, laporan perkembangan, dan rapot.
- Orang tua melihat data anak, presensi, jadwal, rapot, grafik perkembangan, chat, dan mengajukan konseling.

Kalimat sidang:

> Aplikasi ini dibangun untuk memusatkan data administrasi TK, mulai dari pendaftaran, pengelolaan siswa, jadwal, presensi, rapot, sampai komunikasi antara guru dan orang tua.

## 2. Teknologi Yang Dipakai

- Laravel 12: framework utama backend.
- PHP 8.2: bahasa pemrograman server.
- Blade: template tampilan halaman.
- Eloquent ORM: cara Laravel berhubungan dengan database lewat Model.
- MySQL/MariaDB: database yang kemungkinan dipakai dari file `.env`.
- DomPDF: membuat atau mengunduh rapot dalam bentuk PDF.
- Maatwebsite Excel: export data DAPODIK ke Excel.
- Vite: mengelola asset frontend seperti CSS dan JavaScript.

Kalimat sidang:

> Saya menggunakan Laravel karena sudah menyediakan struktur MVC, routing, autentikasi, migration database, dan ORM sehingga pengembangan aplikasi administrasi lebih teratur.

## 3. Pola Dasar Laravel Di Project Ini

Laravel di project ini memakai pola MVC:

- Model: representasi tabel database. Contoh: `Student`, `Classroom`, `ClassTerm`, `Report`.
- View: file tampilan HTML Blade. Contoh: `resources/views/admin/dashboard.blade.php`.
- Controller: penghubung antara request user, database, dan view. Contoh: `AdminController`, `GuruController`, `OrangTuaController`.
- Route: daftar alamat URL dan controller yang dipanggil. File utamanya ada di `routes/web.php`.
- Migration: blueprint struktur tabel database. Ada di `database/migrations`.

Alur sederhananya:

```text
User klik halaman
-> Route menangkap URL
-> Controller memproses logika
-> Model mengambil atau menyimpan data database
-> Controller mengirim data ke View
-> View ditampilkan ke browser
```

Contoh nyata:

```text
Orang tua buka /orangtua/presensi
-> routes/web.php memanggil OrangTuaController@presensi
-> controller mencari siswa berdasarkan user login
-> controller mengambil data Presence dari database
-> view orangtua.presensi menampilkan ringkasan presensi
```

## 4. Struktur Folder Penting

### `routes/web.php`

File ini berisi daftar URL aplikasi. Di sini terlihat aplikasi dibagi menjadi section:

- Auth: login dan logout.
- Pendaftaran: halaman publik tanpa login.
- Admin Routes: hanya untuk role admin.
- Guru Routes: hanya untuk role guru.
- Orang Tua Routes: hanya untuk role orangtua.

Kalimat sidang:

> File route berfungsi sebagai pintu masuk aplikasi. Setiap URL diarahkan ke method controller tertentu, dan beberapa URL dilindungi middleware agar hanya role tertentu yang bisa mengakses.

### `app/Http/Controllers`

Folder ini berisi logika utama aplikasi.

- `AuthController.php`: proses login, logout, dan redirect sesuai role.
- `PendaftaranController.php`: form pendaftaran siswa baru.
- `AdminController.php`: semua fitur admin.
- `GuruController.php`: semua fitur guru.
- `OrangTuaController.php`: semua fitur orang tua.

Kalimat sidang:

> Controller bertugas menerima input dari user, melakukan validasi, memanggil model, lalu mengirim hasilnya ke halaman Blade.

### `app/Models`

Folder ini berisi model Eloquent. Model adalah jembatan antara kode Laravel dan tabel database.

Contoh:

- `Student` terhubung ke tabel `student`.
- `Classroom` terhubung ke tabel `class`.
- `ClassTerm` terhubung ke tabel `class_term`.
- `Report` terhubung ke tabel `report`.
- `Presence` terhubung ke tabel `presence`.

Kalimat sidang:

> Model memudahkan akses database tanpa menulis SQL manual terlalu banyak. Relasi antar tabel juga didefinisikan di model.

### `resources/views`

Folder ini berisi tampilan aplikasi.

- `resources/views/admin`: halaman admin.
- `resources/views/guru`: halaman guru.
- `resources/views/orangtua`: halaman orang tua.
- `resources/views/pendaftaran`: halaman pendaftaran publik.
- `resources/views/auth`: halaman login.
- `resources/views/layouts`: template utama.

Kalimat sidang:

> View adalah bagian tampilan yang dilihat user. Data dari controller dikirim ke view menggunakan fungsi `view()`.

### `database/migrations`

Folder ini berisi struktur tabel database.

Kalimat sidang:

> Migration digunakan untuk membuat dan mengubah struktur tabel secara terkontrol, sehingga struktur database bisa dibangun ulang dari kode.

## 5. Komentar Per Section Route

### Auth

File: `routes/web.php`

Section ini mengatur:

- `/` diarahkan ke login.
- `/login` menampilkan form login.
- `POST /login` memproses email dan password.
- `/logout` menghapus session login.

Controller terkait: `AuthController`.

Inti logika:

- User memasukkan email dan password.
- Laravel mencoba login dengan `Auth::attempt`.
- Jika berhasil, dicek apakah status user `active`.
- User diarahkan sesuai role: admin, guru, atau orang tua.

### Pendaftaran

Section ini bersifat publik, artinya calon orang tua tidak perlu login.

Route penting:

- `/pendaftaran`: form pendaftaran siswa.
- `POST /pendaftaran`: menyimpan data pendaftaran.
- `/pendaftaran/success`: halaman berhasil daftar.
- `/pendaftaran/cek-status`: cek status pendaftaran.

Controller terkait: `PendaftaranController`.

Inti logika:

- Data anak divalidasi.
- Akun orang tua dibuat dengan status `pending`.
- Data siswa dibuat.
- Data ayah, ibu, dan wali disimpan.
- Dokumen seperti akta, KK, dan foto diupload.

Kalimat sidang:

> Saat pendaftaran, sistem langsung membuat akun orang tua berstatus pending. Admin kemudian bisa memproses agar akun menjadi aktif atau ditolak.

### Admin Routes

Section admin dilindungi oleh:

```php
Route::middleware(['dummy.auth', 'role:admin'])
```

Artinya:

- User harus login.
- User harus punya role `admin`.

Fitur admin:

- Dashboard.
- Kelola pengguna.
- Kelola siswa.
- Kelola pendaftaran.
- Kelola tahun ajaran.
- Kelola kelas.
- Kelola ekstrakurikuler.
- Kelola konseling.
- Kelola mata pelajaran.
- Kelola aktivitas tahun ajaran.
- Kenaikan siswa.
- Rekap DAPODIK.
- Backup database.

Controller terkait: `AdminController`.

Kalimat sidang:

> Admin adalah peran yang mengatur data master dan data akademik. Admin memastikan data pengguna, siswa, kelas, tahun ajaran, dan aktivitas pembelajaran sudah siap dipakai oleh guru dan orang tua.

### Guru Routes

Section guru dilindungi oleh:

```php
Route::middleware(['dummy.auth', 'role:guru'])
```

Fitur guru:

- Dashboard guru.
- Input kehadiran.
- Laporan administrasi.
- Kelola jadwal pembelajaran dan kegiatan.
- Input perkembangan.
- Grafik perkembangan.
- Laporan BK.
- Chat dengan orang tua.
- Jadwal konseling.
- Input rapot semester.

Controller terkait: `GuruController`.

Kalimat sidang:

> Guru berperan sebagai pengisi data operasional harian dan akademik, seperti presensi, jadwal, konseling, dan rapot siswa.

### Orang Tua Routes

Section orang tua dilindungi oleh:

```php
Route::middleware(['dummy.auth', 'role:orangtua'])
```

Fitur orang tua:

- Dashboard anak.
- Melihat presensi.
- Melihat laporan.
- Melihat rapot.
- Melihat jadwal pembelajaran dan kegiatan.
- Melihat report mingguan.
- Melihat grafik perkembangan.
- Chat dengan guru.
- Mengajukan jadwal konseling.

Controller terkait: `OrangTuaController`.

Kalimat sidang:

> Orang tua menggunakan sistem untuk memantau perkembangan anak dan berkomunikasi dengan guru tanpa harus selalu datang langsung ke sekolah.

## 6. Komentar Controller Utama

### `AuthController`

Tugas:

- Menampilkan halaman login.
- Memproses login.
- Menolak login jika akun belum aktif.
- Logout.
- Mengarahkan user sesuai role.

Method penting:

- `showLogin()`: tampilkan login.
- `login()`: validasi email dan password.
- `logout()`: keluar dari sistem.
- `redirectByRole()`: arahkan ke dashboard sesuai role.

Poin sidang:

> Login tidak hanya mengecek email dan password, tetapi juga mengecek status akun agar akun pending atau inactive tidak bisa masuk.

### `PendaftaranController`

Tugas:

- Menampilkan form pendaftaran.
- Menyimpan data calon siswa.
- Membuat akun orang tua.
- Menyimpan dokumen pendaftaran.
- Mengecek status pendaftaran.

Poin penting:

- Ada validasi input supaya data wajib tidak kosong.
- `DB::transaction` dipakai agar proses simpan data aman. Jika salah satu proses gagal, data yang lain ikut dibatalkan.
- Password orang tua disimpan dengan `Hash::make`, bukan teks biasa.

Poin sidang:

> Saya memakai transaksi database pada pendaftaran karena satu proses pendaftaran menyimpan beberapa tabel sekaligus: user, student, parents, dan student_file.

### `AdminController`

Tugas:

- Mengelola semua data master dan proses administrasi.

Section penting:

- Dashboard: menghitung total siswa, guru, kelas, dan aktivitas terbaru.
- Kelola pengguna: CRUD akun admin/guru/orang tua.
- Kelola siswa: CRUD data siswa dan orang tua.
- Kelola pendaftaran: menerima atau menolak pendaftaran.
- Tahun ajaran: membuat periode akademik.
- Kelas: membuat kelas seperti A, B1, B2.
- Aktivitas tahun ajaran: menghubungkan kelas dengan mata pelajaran, ekskul, dan konseling.
- Kenaikan siswa: memindahkan siswa ke class term berikutnya.
- DAPODIK: rekap data siswa untuk kebutuhan administrasi.
- Backup: membuat, restore, download, dan hapus backup database.

Poin sidang:

> AdminController menjadi pusat pengelolaan data master. Data yang dibuat admin akan dipakai oleh guru saat mengisi jadwal, presensi, dan rapot.

### `GuruController`

Tugas:

- Mengelola aktivitas guru.

Section penting:

- Kehadiran: guru memilih kelas dan tanggal, lalu menyimpan status hadir/izin/sakit/alpa.
- Jadwal: guru membuat jadwal pembelajaran dan kegiatan.
- Konseling: guru membuat jadwal konseling per siswa atau per kelas.
- Chat: guru berkomunikasi dengan orang tua.
- Rapot: guru mengisi rapot siswa berdasarkan mata pelajaran, ekskul, dan konseling.
- Grafik/laporan BK: menampilkan perkembangan siswa.

Poin sidang:

> GuruController memproses data yang bersifat akademik dan harian, lalu hasilnya bisa dilihat oleh orang tua.

### `OrangTuaController`

Tugas:

- Menampilkan informasi anak kepada orang tua.

Section penting:

- Dashboard: ringkasan anak, kehadiran, rapot, dan konseling.
- Presensi: detail kehadiran anak per bulan.
- Jadwal: jadwal pembelajaran dan kegiatan.
- Rapot: daftar dan detail rapot siswa.
- Report mingguan: perkembangan konseling per minggu.
- Grafik: visualisasi perkembangan anak.
- Chat: komunikasi dengan guru.
- Konseling: pengajuan jadwal konseling.

Poin sidang:

> OrangTuaController mengambil data berdasarkan user yang sedang login, jadi orang tua hanya melihat data anak yang terhubung dengan akunnya.

## 7. Middleware Dan Role

Middleware adalah penjaga akses sebelum user masuk ke halaman.

### `DummyAuth`

Tugas:

- Mengecek apakah user sudah login.
- Mengecek status user harus `active`.
- Jika belum login atau tidak aktif, dikembalikan ke login.

### `RoleMiddleware`

Tugas:

- Mengecek apakah role user sesuai dengan halaman.
- Jika role tidak sesuai, sistem mengembalikan error 403.

Contoh:

- Admin tidak boleh masuk halaman guru.
- Guru tidak boleh masuk halaman admin.
- Orang tua tidak boleh masuk halaman admin.

Kalimat sidang:

> Pembatasan akses dilakukan menggunakan middleware, sehingga setiap role hanya dapat mengakses fitur yang sesuai.

## 8. Database Dan Relasi Penting

### `user`

Menyimpan akun login.

Kolom penting:

- `name`: nama user.
- `email`: email login.
- `password`: password yang sudah di-hash.
- `role`: admin, guru, atau orangtua.
- `status`: active, pending, inactive.

Relasi:

- Satu user orang tua bisa terhubung ke satu student.

### `student`

Menyimpan data siswa.

Kolom penting:

- `user_id`: akun orang tua.
- `name`: nama siswa.
- `nis`, `nisn`, `nik`: identitas siswa.
- `gender`: jenis kelamin.
- `dob`: tanggal lahir.
- `address`: alamat.

Relasi:

- Siswa punya banyak parent data di `parents`.
- Siswa punya banyak dokumen di `student_file`.
- Siswa punya banyak riwayat kelas di `student_enrollment`.

### `parents`

Menyimpan data ayah, ibu, atau wali.

Kolom penting:

- `student_id`: siswa terkait.
- `category`: ayah, ibu, wali.
- `name`: nama orang tua/wali.
- `work`: pekerjaan.
- `education`: pendidikan.

### `class`

Menyimpan data kelas.

Contoh isi:

- A
- B1
- B2

Model terkait: `Classroom`.

### `academic_term`

Menyimpan tahun ajaran dan semester.

Contoh:

- Tahun ajaran: 2025/2026
- Semester: ganjil atau genap
- Status: menunggu, aktif, selesai

### `class_term`

Menghubungkan kelas dengan tahun ajaran.

Contoh:

- Kelas A pada tahun ajaran 2025/2026 semester ganjil.
- Kelas B1 pada tahun ajaran 2025/2026 semester genap.

Kenapa perlu tabel ini?

Karena kelas yang sama bisa muncul di banyak tahun ajaran dan semester.

Kalimat sidang:

> `class_term` adalah penghubung antara kelas dan tahun ajaran, sehingga data siswa, jadwal, presensi, dan rapot bisa dibedakan per semester.

### `student_enrollment`

Menyimpan riwayat siswa berada di class term tertentu.

Contoh:

- Ahmad masuk ClassTerm Kelas A semester ganjil.
- Semester berikutnya Ahmad naik ke ClassTerm Kelas B1.

Kolom penting:

- `student_id`
- `class_term_id`
- `status`: aktif, naik, tinggal, pindah.
- `aksi`: ganti semester, ganti kelas, tinggal kelas.

### `presence`

Menyimpan presensi siswa.

Kolom penting:

- `student_class_id`: id dari `student_enrollment`.
- `date`: tanggal.
- `attendance`: hadir, izin, sakit, alpa.
- `description`: keterangan.

### `class_schedule`

Menyimpan jadwal pembelajaran mingguan.

Contoh:

- Senin jam 08:00 sampai 09:00 kegiatan membaca.

### `activity_schedule`

Menyimpan jadwal kegiatan berdasarkan tanggal.

Contoh:

- Outing class.
- Manasik haji.
- Peringatan hari besar.

### `report`

Menyimpan rapot siswa per enrollment.

Relasi:

- `report_subject`: deskripsi mata pelajaran.
- `report_subject_image`: foto kegiatan mata pelajaran.
- `report_extracurricular`: data ekskul.
- `report_extracurricular_score`: nilai ekskul.
- `report_counseling`: data konseling/BK.
- `report_counseling_score`: nilai perkembangan konseling.

### `chat_room` dan `chat_message`

Menyimpan fitur chat.

- `chat_room`: ruang percakapan antara dua user.
- `chat_message`: isi pesan dalam ruang chat.

### `private_counseling_schedule`

Menyimpan jadwal konseling.

Kolom penting:

- `student_id`: akun orang tua, bisa kosong jika konseling per kelas.
- `teacher_id`: guru.
- `class_term_id`: kelas dan semester.
- `status`: pending, approved, rejected, canceled.
- `date`, `start_hour`, `end_hour`.
- `topic`: topik konseling.
- `source`: dibuat oleh guru atau orang tua.

## 9. Penjelasan Model `Classroom`

Kode:

```php
class Classroom extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'maximum'];

    protected function casts(): array
    {
        return ['maximum' => 'integer'];
    }

    public function classTerms()
    {
        return $this->hasMany(ClassTerm::class, 'class_id');
    }
}
```

Komentar per section:

- `class Classroom extends Model`: membuat model Laravel bernama Classroom.
- `use HasUuids`: id menggunakan UUID, bukan angka urut biasa.
- `use SoftDeletes`: data tidak langsung hilang permanen, tetapi ditandai di kolom `deleted_at`.
- `protected $table = 'class'`: model ini memakai tabel database bernama `class`.
- `protected $keyType = 'string'`: id bertipe string karena UUID.
- `public $incrementing = false`: id tidak auto increment seperti 1, 2, 3.
- `protected $fillable = ['name', 'maximum']`: hanya kolom `name` dan `maximum` yang boleh diisi massal.
- `casts maximum integer`: nilai kapasitas maksimum dibaca sebagai angka.
- `classTerms()`: satu kelas bisa muncul di banyak tahun ajaran/semester.

Kalimat sidang:

> Model Classroom merepresentasikan data kelas. Satu kelas dapat memiliki banyak class term karena kelas yang sama bisa digunakan pada tahun ajaran atau semester yang berbeda.

## 10. Alur Fitur Penting

### Alur Login

```text
User membuka /login
-> mengisi email dan password
-> AuthController@login memvalidasi
-> jika benar dan active, diarahkan sesuai role
-> admin ke /admin/dashboard
-> guru ke /guru/dashboard
-> orang tua ke /orangtua/dashboard
```

### Alur Pendaftaran Siswa Baru

```text
Calon orang tua buka /pendaftaran
-> mengisi data anak, orang tua, dan upload dokumen
-> PendaftaranController@store memvalidasi data
-> membuat akun user role orangtua status pending
-> membuat data student
-> membuat data parents
-> menyimpan dokumen
-> diarahkan ke halaman sukses
```

### Alur Admin Menerima Pendaftaran

```text
Admin melihat daftar pendaftaran
-> admin membuka detail siswa
-> admin menerima pendaftaran
-> status akun orang tua menjadi active
-> siswa dapat dipakai dalam proses akademik
```

### Alur Guru Input Presensi

```text
Guru buka /guru/kehadiran
-> pilih class term dan tanggal
-> sistem menampilkan siswa di kelas tersebut
-> guru mengisi hadir/izin/sakit/alpa
-> data disimpan ke tabel presence
-> orang tua bisa melihatnya di menu presensi
```

### Alur Guru Input Rapot

```text
Guru buka menu rapot
-> pilih class term
-> pilih siswa
-> input deskripsi mata pelajaran, nilai ekskul, dan nilai konseling
-> data disimpan ke report dan tabel turunannya
-> orang tua melihat detail rapot
```

### Alur Konseling

Ada dua sumber jadwal konseling:

- Guru membuat jadwal untuk siswa atau kelas.
- Orang tua mengajukan jadwal ke guru.

Alur orang tua:

```text
Orang tua buka menu konseling
-> klik ajukan konseling
-> pilih guru, tanggal, waktu, dan topik
-> status awal pending
-> guru dapat menyetujui atau menolak
```

### Alur Chat

```text
User membuka menu chat
-> memilih lawan bicara
-> sistem membuat atau membuka chat_room
-> pesan disimpan ke chat_message
-> pesan tampil berdasarkan room aktif
```

## 11. Istilah Laravel Yang Wajib Paham

### Route

Route adalah daftar alamat URL aplikasi.

Contoh:

```php
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
```

Artinya:

Jika user membuka `/login`, Laravel memanggil method `showLogin()` di `AuthController`.

### Controller

Controller adalah tempat logika.

Contoh tugas controller:

- Validasi input.
- Ambil data dari database.
- Simpan data.
- Kirim data ke view.

### Model

Model adalah perwakilan tabel database.

Contoh:

```php
Student::where('user_id', $user->id)->first();
```

Artinya:

Cari siswa yang terhubung dengan user login.

### View

View adalah tampilan halaman.

Contoh:

```php
return view('admin.dashboard', compact('totalSiswa'));
```

Artinya:

Tampilkan halaman dashboard admin dan kirim variabel `$totalSiswa`.

### Migration

Migration adalah file pembuat struktur tabel.

### Middleware

Middleware adalah penjaga sebelum request masuk ke controller.

### Validation

Validation memastikan input user sesuai aturan.

Contoh:

```php
'email_ortu' => 'required|email|unique:user,email'
```

Artinya email wajib diisi, format harus email, dan tidak boleh sama dengan email yang sudah ada.

### Fillable

`fillable` menentukan kolom mana yang boleh diisi secara massal.

### Casts

`casts` mengubah tipe data otomatis.

Contoh:

```php
'maximum' => 'integer'
```

Artinya nilai maximum dibaca sebagai angka.

### Soft Delete

Soft delete berarti data tidak langsung dihapus permanen. Laravel mengisi kolom `deleted_at`.

### UUID

UUID adalah id unik berbentuk string panjang. Project ini banyak memakai UUID untuk primary key.

## 12. Contoh Pertanyaan Sidang Dan Jawaban

### Apa tujuan aplikasi ini?

Jawaban:

> Tujuan aplikasi ini adalah membantu TK Al-Istiqomah mengelola administrasi siswa, pendaftaran, presensi, jadwal, rapot, konseling, dan komunikasi antara guru dengan orang tua dalam satu sistem.

### Kenapa ada role admin, guru, dan orang tua?

Jawaban:

> Karena setiap pengguna memiliki kebutuhan berbeda. Admin mengelola data master, guru mengisi data akademik dan kegiatan, sedangkan orang tua hanya melihat data anak dan melakukan komunikasi atau pengajuan konseling.

### Bagaimana sistem membatasi akses?

Jawaban:

> Sistem menggunakan middleware. `DummyAuth` memastikan user sudah login dan aktif, sedangkan `RoleMiddleware` memastikan user hanya masuk ke halaman sesuai role.

### Apa itu `class_term`?

Jawaban:

> `class_term` adalah penghubung antara kelas dan tahun ajaran. Dengan tabel ini, kelas A semester ganjil dan kelas A semester genap bisa dibedakan.

### Kenapa data siswa tidak langsung dihapus?

Jawaban:

> Banyak model memakai SoftDeletes, sehingga data yang dihapus masih tersimpan dengan tanda `deleted_at`. Ini berguna untuk keamanan data dan riwayat administrasi.

### Bagaimana alur data presensi?

Jawaban:

> Guru memilih kelas dan tanggal, lalu mengisi status kehadiran siswa. Data disimpan di tabel `presence` berdasarkan `student_enrollment`. Orang tua kemudian bisa melihat data tersebut dari menu presensi.

### Bagaimana alur rapot?

Jawaban:

> Guru memilih class term dan siswa, lalu mengisi deskripsi mata pelajaran, nilai ekskul, dan konseling. Data disimpan di tabel `report` dan tabel detailnya. Orang tua dapat melihat atau mengunduh rapot tersebut.

### Bagaimana pendaftaran siswa baru bekerja?

Jawaban:

> Calon orang tua mengisi form pendaftaran dan upload dokumen. Sistem membuat akun orang tua dengan status pending, membuat data siswa, menyimpan data orang tua, dan menyimpan dokumen. Setelah itu admin dapat memproses statusnya.

### Kenapa memakai Laravel?

Jawaban:

> Laravel menyediakan struktur MVC, routing, middleware, validasi, migration, dan Eloquent ORM. Fitur tersebut membuat pengembangan aplikasi lebih rapi dan mudah dipelihara.

### Apa fungsi Eloquent relationship?

Jawaban:

> Relationship memudahkan pengambilan data yang saling terhubung. Misalnya siswa memiliki banyak enrollment, enrollment memiliki satu class term, dan class term memiliki satu kelas serta tahun ajaran.

## 13. Urutan Belajar Yang Disarankan

1. Pahami dulu tujuan aplikasi dan tiga role utama.
2. Baca `routes/web.php` untuk melihat daftar fitur.
3. Baca `AuthController` agar paham login dan role.
4. Baca `PendaftaranController` agar paham alur pendaftaran.
5. Baca model utama: `User`, `Student`, `Classroom`, `ClassTerm`, `StudentEnrollment`, `Presence`, `Report`.
6. Baca bagian admin untuk data master.
7. Baca bagian guru untuk presensi, jadwal, konseling, dan rapot.
8. Baca bagian orang tua untuk melihat hasil data.
9. Latih menjelaskan alur fitur dalam bentuk "user melakukan apa, controller apa, tabel apa, hasilnya apa".

## 14. Cara Menjelaskan Satu Fitur Saat Sidang

Pakai format ini:

```text
Fitur:
Siapa pengguna:
File route:
Controller:
Model/tabel:
Alur:
Hasil:
```

Contoh:

```text
Fitur: Presensi siswa
Siapa pengguna: Guru dan Orang Tua
File route: routes/web.php
Controller: GuruController dan OrangTuaController
Model/tabel: Presence, StudentEnrollment, Student, ClassTerm
Alur: Guru mengisi presensi, data disimpan ke presence, orang tua melihat rekap presensi anak.
Hasil: Orang tua bisa memantau kehadiran anak per bulan.
```

## 15. Catatan Penting Untuk Kamu

Kamu tidak perlu menghafal semua kode baris per baris. Yang penting saat sidang:

- Paham tujuan aplikasi.
- Paham role pengguna.
- Paham alur MVC.
- Paham route mengarah ke controller.
- Paham controller memakai model untuk database.
- Paham data utama: user, student, class, academic term, class term, enrollment, presence, report.
- Bisa menjelaskan satu fitur dari awal sampai akhir.

Kalimat penutup sidang:

> Secara keseluruhan, aplikasi ini membantu sekolah mengelola data administrasi dan perkembangan siswa secara terpusat, dengan pembagian hak akses sesuai peran admin, guru, dan orang tua.
