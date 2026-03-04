<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pendaftaran - TK AL-ISTIQOMAH</title>
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
            background: linear-gradient(135deg, #e0f2fe 0%, #fce7f3 50%, #fef3e2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Background */
        .bg-decoration {
            position: fixed;
            pointer-events: none;
            z-index: 0;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.15) 0%, rgba(14, 165, 233, 0.1) 100%);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(244, 114, 182, 0.12) 0%, rgba(236, 72, 153, 0.08) 100%);
            border-radius: 50%;
            bottom: 10%;
            right: -80px;
        }

        .status-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .card-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .header-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .header-icon svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .card-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .card-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Form */
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

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 16px 16px 16px 46px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            color: #1e293b;
            background: #f9fafb;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .input-wrapper:focus-within svg {
            color: #3b82f6;
        }

        .form-group input::placeholder {
            color: #9ca3af;
            text-transform: none;
            letter-spacing: normal;
            font-weight: 400;
        }

        .btn-submit {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
        }

        .btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 24px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-secondary svg {
            width: 18px;
            height: 18px;
        }

        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-message svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Result Section */
        .result-section {
            margin-top: 32px;
            padding-top: 32px;
            border-top: 2px solid #f1f5f9;
        }

        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .result-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .status-review {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .status-approved {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-rejected {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 14px 0;
            font-size: 0.9rem;
        }

        .info-table td:first-child {
            color: #64748b;
            width: 40%;
            font-weight: 500;
        }

        .info-table td:last-child {
            color: #1e293b;
            font-weight: 600;
        }

        .admin-notes {
            background: linear-gradient(135deg, #fef3e2 0%, #fef9c3 100%);
            border-radius: 12px;
            padding: 16px;
            margin-top: 20px;
        }

        .admin-notes h3 {
            font-size: 0.8rem;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-notes p {
            color: #78350f;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            padding: 20px 0 0;
            color: #9ca3af;
            font-size: 0.75rem;
            margin-top: 24px;
        }

        @media (max-width: 480px) {
            .status-card {
                padding: 28px 24px;
            }

            .header-icon {
                width: 60px;
                height: 60px;
                border-radius: 14px;
            }

            .header-icon svg {
                width: 28px;
                height: 28px;
            }

            .card-header h1 {
                font-size: 1.25rem;
            }

            .result-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Decorations -->
    <div class="bg-decoration circle-1"></div>
    <div class="bg-decoration circle-2"></div>

    <div class="status-card">
        <div class="card-header">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <h1>Cek Status Pendaftaran</h1>
            <p>Masukkan kode pendaftaran untuk melihat status</p>
        </div>

        @if (session('error'))
            <div class="error-message">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="GET" action="{{ route('pendaftaran.cek-status') }}">
            <div class="form-group">
                <label>Kode Pendaftaran</label>
                <div class="input-wrapper">
                    <input type="text" name="kode" value="{{ request('kode') }}" placeholder="Masukkan kode pendaftaran" required>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                CEK STATUS
            </button>
            <a href="{{ route('pendaftaran.create') }}" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Daftar Baru
            </a>
        </form>

        @if(isset($registration))
            <div class="result-section">
                <div class="result-header">
                    <h2>Hasil Pencarian</h2>
                    @php
                        $statusClass = match($registration->status) {
                            'pending' => 'status-pending',
                            'review' => 'status-review',
                            'approved' => 'status-approved',
                            'rejected' => 'status-rejected',
                            default => 'status-pending'
                        };
                        $statusText = match($registration->status) {
                            'pending' => 'Menunggu',
                            'review' => 'Sedang Ditinjau',
                            'approved' => 'Diterima',
                            'rejected' => 'Ditolak',
                            default => 'Menunggu'
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>

                <table class="info-table">
                    <tr>
                        <td>Kode Pendaftaran</td>
                        <td>{{ $registration->kode_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td>Nama Anak</td>
                        <td>{{ $registration->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Daftar</td>
                        <td>{{ $registration->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>{{ $registration->telepon }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $registration->email }}</td>
                    </tr>
                </table>

                @if($registration->catatan_admin)
                    <div class="admin-notes">
                        <h3>Catatan dari Admin</h3>
                        <p>{{ $registration->catatan_admin }}</p>
                    </div>
                @endif
            </div>
        @endif

        <div class="footer">
            &copy; 2026 TK Al-Istiqomah. All rights reserved.
        </div>
    </div>
</body>
</html>
