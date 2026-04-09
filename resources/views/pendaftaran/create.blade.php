<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa Baru - TK AL-ISTIQOMAH</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #FFFDE7 0%, #F9FBE7 50%, #E8F5E9 100%);
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Background Elements */
        .bg-decoration {
            position: fixed;
            pointer-events: none;
            z-index: 0;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(76, 175, 130, 0.15) 0%, rgba(61, 155, 114, 0.1) 100%);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(244, 114, 182, 0.12) 0%, rgba(236, 72, 153, 0.08) 100%);
            border-radius: 50%;
            top: 60%;
            right: -80px;
        }

        .circle-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.12) 0%, rgba(14, 165, 233, 0.08) 100%);
            border-radius: 50%;
            bottom: 10%;
            left: 5%;
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 30%, #2E8B60 60%, #E8F5E9 100%);
            padding: 32px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 16px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: white;
        }

        .back-link svg {
            width: 18px;
            height: 18px;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 8px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        /* Main Content */
        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 32px 20px;
            position: relative;
            z-index: 1;
        }

        /* Form Card */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 32px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #3E2723;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-icon svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .section-icon.orange {
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        }

        .section-icon.green {
            background: linear-gradient(135deg, #3D9B72 0%, #16a34a 100%);
        }

        .section-icon.blue {
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        }

        .section-icon.purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .section-desc {
            color: #5D4037;
            font-size: 0.9rem;
            margin-top: -16px;
            margin-bottom: 20px;
        }

        .subsection-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #3E2723;
            margin: 20px 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 1px dashed #3E272330;
        }

        .subsection-desc {
            color: #5D4037;
            font-size: 0.8rem;
            margin-top: -8px;
            margin-bottom: 12px;
        }

        .form-hint {
            display: block;
            color: #5D4037;
            font-size: 0.75rem;
            margin-top: 4px;
        }

        /* Form Grid */
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-row.single {
            grid-template-columns: 1fr;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #3E2723;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #c0392b;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #3E272320;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #3E2723;
            background: #FFFDE7;
            transition: all 0.2s ease;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3D9B72;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(76, 175, 130, 0.1);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #5D4037;
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
            border: 2px dashed #3E272320;
            border-radius: 12px;
            padding: 20px;
            background: #FFFDE7;
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            border-color: #3D9B72;
            background: #fff7ed;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-input-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            background: #FFF176;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-input-icon svg {
            width: 24px;
            height: 24px;
            color: #3D9B72;
        }

        .file-input-text {
            font-size: 0.9rem;
            color: #5D4037;
        }

        .file-input-text strong {
            color: #3D9B72;
        }

        .file-hint {
            font-size: 0.75rem;
            color: #5D4037;
            margin-top: 8px;
        }

        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            color: #c0392b;
            padding: 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .error-message svg {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 18px 32px;
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(76, 175, 130, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(76, 175, 130, 0.4);
        }

        .btn-submit svg {
            width: 22px;
            height: 22px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 24px;
            color: #5D4037;
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .page-header {
                padding: 24px 16px;
            }

            .page-header h1 {
                font-size: 1.4rem;
            }

            .main-container {
                padding: 20px 16px;
            }

            .form-card {
                padding: 24px 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 1rem;
            }

            .section-icon {
                width: 36px;
                height: 36px;
            }

            .section-icon svg {
                width: 18px;
                height: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Decorations -->
    <div class="bg-decoration circle-1"></div>
    <div class="bg-decoration circle-2"></div>
    <div class="bg-decoration circle-3"></div>

    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <a href="{{ route('login') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Login
            </a>
            <h1>Pendaftaran Siswa Baru</h1>
            <p>TK AL-ISTIQOMAH - Tahun Ajaran 2026/2027</p>
        </div>
    </div>

    <div class="main-container">
        @if ($errors->any())
            <div class="error-message">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <strong>Mohon periksa kembali data Anda:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Data Siswa -->
            <div class="form-card">
                <h2 class="section-title">
                    <span class="section-icon orange">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    I. Identitas Anak
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Anak <span class="required">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap anak" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Panggilan <span class="required">*</span></label>
                        <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" placeholder="Nama panggilan sehari-hari" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="required">*</span></label>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Agama <span class="required">*</span></label>
                        <select name="agama" required>
                            <option value="">Pilih agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir <span class="required">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Bandar Lampung" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Anak ke <span class="required">*</span></label>
                        <input type="number" name="anak_ke" value="{{ old('anak_ke') }}" placeholder="Contoh: 2" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Saudara <span class="required">*</span></label>
                        <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" placeholder="Contoh: 1" min="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Suku Bangsa</label>
                        <input type="text" name="suku_bangsa" value="{{ old('suku_bangsa') }}" placeholder="Contoh: Jawa, Lampung, dll">
                    </div>
                    <div class="form-group">
                        <label>Riwayat Penyakit</label>
                        <input type="text" name="riwayat_penyakit" value="{{ old('riwayat_penyakit') }}" placeholder="Kosongkan jika tidak ada">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Berat Badan (kg)</label>
                        <input type="text" name="berat_badan" value="{{ old('berat_badan') }}" placeholder="Contoh: 13">
                    </div>
                    <div class="form-group">
                        <label>Tinggi Badan (cm)</label>
                        <input type="text" name="tinggi_badan" value="{{ old('tinggi_badan') }}" placeholder="Contoh: 95">
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label>Alamat <span class="required">*</span></label>
                        <textarea name="alamat" placeholder="Masukkan alamat lengkap tempat tinggal" required>{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label>No. Telp / HP <span class="required">*</span></label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Contoh: 0822 8965 2973" required>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="form-card">
                <h2 class="section-title">
                    <span class="section-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    II. Identitas Orang Tua / Wali Murid
                </h2>

                <h3 class="subsection-title">1. Ayah</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ayah <span class="required">*</span></label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" placeholder="Masukkan nama lengkap ayah" required>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan / Pendidikan</label>
                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" placeholder="Contoh: Buruh">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir Ayah</label>
                        <input type="text" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}" placeholder="Contoh: Pemalang">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir Ayah</label>
                        <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}">
                    </div>
                </div>

                <h3 class="subsection-title">2. Ibu</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ibu <span class="required">*</span></label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" placeholder="Masukkan nama lengkap ibu" required>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan / Pendidikan</label>
                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" placeholder="Contoh: Pengurus Rumah Tangga">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir Ibu</label>
                        <input type="text" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}" placeholder="Contoh: Teratkulon">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir Ibu</label>
                        <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}">
                    </div>
                </div>

                <h3 class="subsection-title">3. Wali (Opsional)</h3>
                <p class="subsection-desc">Isi jika ada wali selain orang tua</p>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Wali</label>
                        <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" placeholder="Nama lengkap wali">
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan / Pendidikan</label>
                        <input type="text" name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}" placeholder="Pekerjaan wali">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir Wali</label>
                        <input type="text" name="tempat_lahir_wali" value="{{ old('tempat_lahir_wali') }}" placeholder="Tempat lahir wali">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir Wali</label>
                        <input type="date" name="tanggal_lahir_wali" value="{{ old('tanggal_lahir_wali') }}">
                    </div>
                </div>
            </div>

            <!-- Akun Orang Tua -->
            <div class="form-card">
                <h2 class="section-title">
                    <span class="section-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </span>
                    Akun Orang Tua
                </h2>
                <p class="section-desc">Akun ini akan digunakan untuk login ke sistem dan memantau perkembangan anak</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email_ortu" value="{{ old('email_ortu') }}" placeholder="Contoh: email@example.com" required>
                        <span class="form-hint">Email ini akan digunakan untuk login</span>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <input type="password" name="password_ortu" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
            </div>

            <!-- Upload Dokumen -->
            <div class="form-card">
                <h2 class="section-title">
                    <span class="section-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    Upload Dokumen
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Akta Kelahiran <span class="required">*</span></label>
                        <div class="file-input-wrapper">
                            <input type="file" name="akta_kelahiran" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="file-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="file-input-text">Klik untuk <strong>upload file</strong></p>
                            <p class="file-hint">PDF, JPG, PNG (Maks. 2MB)</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kartu Keluarga <span class="required">*</span></label>
                        <div class="file-input-wrapper">
                            <input type="file" name="kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="file-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="file-input-text">Klik untuk <strong>upload file</strong></p>
                            <p class="file-hint">PDF, JPG, PNG (Maks. 2MB)</p>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Pas Foto Anak <span class="required">*</span></label>
                        <div class="file-input-wrapper">
                            <input type="file" name="foto" accept=".jpg,.jpeg,.png" required>
                            <div class="file-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="file-input-text">Klik untuk <strong>upload foto</strong></p>
                            <p class="file-hint">JPG, PNG (Maks. 2MB) - Ukuran 3x4</p>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                KIRIM PENDAFTARAN
            </button>
        </form>

        <div class="footer">
            &copy; 2026 TK Al-Istiqomah. All rights reserved.
        </div>
    </div>
</body>
</html>
