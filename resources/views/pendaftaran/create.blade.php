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
            background: linear-gradient(135deg, #fef3e2 0%, #fce7f3 50%, #e0f2fe 100%);
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
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(251, 146, 60, 0.1) 100%);
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
            background: linear-gradient(135deg, #ff9a56 0%, #ffad60 30%, #ffc971 60%, #ffecd2 100%);
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
            color: #1e293b;
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
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .section-icon.green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .section-icon.blue {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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
            color: #374151;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #1e293b;
            background: #f9fafb;
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
            border-color: #f97316;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #9ca3af;
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            background: #f9fafb;
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            border-color: #f97316;
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
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-input-icon svg {
            width: 24px;
            height: 24px;
            color: #f97316;
        }

        .file-input-text {
            font-size: 0.9rem;
            color: #64748b;
        }

        .file-input-text strong {
            color: #f97316;
        }

        .file-hint {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 8px;
        }

        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            color: #dc2626;
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
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.4);
        }

        .btn-submit svg {
            width: 22px;
            height: 22px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 24px;
            color: #9ca3af;
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
                    Data Calon Siswa
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap anak" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="required">*</span></label>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir <span class="required">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jakarta" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label>Alamat Anak <span class="required">*</span></label>
                        <textarea name="alamat_siswa" placeholder="Masukkan alamat lengkap tempat tinggal anak" required>{{ old('alamat_siswa') }}</textarea>
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
                    Data Orang Tua / Wali
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ayah <span class="required">*</span></label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" placeholder="Masukkan nama lengkap ayah" required>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" placeholder="Contoh: Wiraswasta">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ibu <span class="required">*</span></label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" placeholder="Masukkan nama lengkap ibu" required>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" placeholder="Contoh: Ibu Rumah Tangga">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>No. Telepon / WhatsApp <span class="required">*</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="Contoh: 08123456789" required>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: email@example.com" required>
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label>Alamat Orang Tua <span class="required">*</span></label>
                        <textarea name="alamat_ortu" placeholder="Masukkan alamat lengkap orang tua" required>{{ old('alamat_ortu') }}</textarea>
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
