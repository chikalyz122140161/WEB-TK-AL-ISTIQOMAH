<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Konseling Baru</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .wrapper {
            max-width: 620px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #E65100, #FB8C00);
            padding: 30px 32px;
            text-align: center;
        }
        .header .icon-circle {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .header p {
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            margin-top: 4px;
        }
        .badge {
            display: inline-block;
            margin-top: 14px;
            background: rgba(255,255,255,0.22);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 5px 18px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.4);
            letter-spacing: 0.4px;
        }
        .body { padding: 28px 32px; }
        .greeting {
            font-size: 15px;
            color: #444;
            margin-bottom: 18px;
            line-height: 1.6;
        }
        .greeting strong { color: #E65100; }
        .alert-warning {
            background: #fff3e0;
            border: 1px solid #ffcc80;
            border-left: 4px solid #E65100;
            border-radius: 0 8px 8px 0;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            line-height: 1.6;
            color: #bf360c;
        }
        .alert-warning strong { font-weight: 700; }
        .info-box {
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 22px;
        }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box td {
            padding: 6px 0;
            font-size: 13.5px;
            vertical-align: top;
        }
        .info-box td:first-child {
            color: #666;
            width: 38%;
            font-weight: 500;
        }
        .info-box td:last-child {
            color: #222;
            font-weight: 600;
        }
        .note {
            font-size: 13px;
            color: #666;
            background: #fafafa;
            border-left: 3px solid #FB8C00;
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .footer {
            background: #f8f8f8;
            border-top: 1px solid #eee;
            padding: 20px 32px;
            text-align: center;
        }
        .footer p {
            font-size: 12px;
            color: #999;
            margin-bottom: 4px;
        }
        .footer .school-name {
            font-size: 13px;
            font-weight: 700;
            color: #2E7D32;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- ── HEADER ──────────────────────────────────── --}}
    <div class="header">
        <div class="icon-circle">
            {{-- Bell / notification icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1>TK Al-Istiqomah</h1>
        <p>Notifikasi Pengajuan Konseling</p>
        <span class="badge">Menunggu Persetujuan</span>
    </div>

    {{-- ── BODY ─────────────────────────────────────── --}}
    <div class="body">

        <p class="greeting">
            Yth. <strong>{{ $namaGuru }}</strong>,<br>
            Ada pengajuan jadwal konseling baru dari orang tua siswa yang perlu Anda tinjau.
        </p>

        {{-- Alert --}}
        <div class="alert-warning">
            <strong>{{ $namaOrtu }}</strong> (orang tua dari <strong>{{ $namaSiswa }}</strong>)
            telah mengajukan jadwal konseling. Silakan masuk ke sistem untuk
            <strong>menyetujui</strong> atau <strong>menolak</strong> pengajuan ini.
        </div>

        {{-- Detail Pengajuan --}}
        <div class="info-box">
            <table>
                <tr>
                    <td>Nama Orang Tua</td>
                    <td>: {{ $namaOrtu }}</td>
                </tr>
                <tr>
                    <td>Nama Siswa</td>
                    <td>: {{ $namaSiswa }}</td>
                </tr>
                <tr>
                    <td>Topik</td>
                    <td>: {{ $topik }}</td>
                </tr>
                <tr>
                    <td>Tanggal Usulan</td>
                    <td>: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Waktu Usulan</td>
                    <td>: {{ $waktu }} WIB</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: <strong>Menunggu Persetujuan</strong></td>
                </tr>
            </table>
        </div>

        {{-- Catatan --}}
        <div class="note">
            Silakan masuk ke <strong>Sistem Informasi TK Al-Istiqomah</strong> dan buka menu
            <strong>Jadwal Konseling</strong> untuk menyetujui atau menolak pengajuan ini.
        </div>

    </div>

    {{-- ── FOOTER ──────────────────────────────────── --}}
    <div class="footer">
        <p class="school-name">TK Al-Istiqomah</p>
        <p>Email ini dikirim otomatis oleh Sistem Informasi TK Al-Istiqomah.</p>
        <p>Mohon tidak membalas email ini.</p>
    </div>

</div>
</body>
</html>
