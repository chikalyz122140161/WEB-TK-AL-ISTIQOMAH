<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Konseling Baru</title>
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
            background: linear-gradient(135deg, #1565C0, #1E88E5);
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
        .greeting strong { color: #1565C0; }
        .alert-info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-left: 4px solid #1565C0;
            border-radius: 0 8px 8px 0;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            line-height: 1.6;
            color: #0d47a1;
        }
        .alert-info strong { font-weight: 700; }
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
            border-left: 3px solid #1E88E5;
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
            {{-- Calendar icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1>TK Al-Istiqomah</h1>
        <p>Notifikasi Jadwal Konseling Baru</p>
        <span class="badge">
            {{ $tipe === 'per_kelas' ? 'Konseling Kelas' : 'Konseling Siswa' }}
        </span>
    </div>

    {{-- ── BODY ─────────────────────────────────────── --}}
    <div class="body">

        <p class="greeting">
            Yth. Bapak/Ibu <strong>{{ $namaOrtu }}</strong>,<br>
            Guru telah menjadwalkan sesi konseling untuk putra/putri Anda.
        </p>

        {{-- Alert Info --}}
        <div class="alert-info">
            @if ($tipe === 'per_kelas')
                Sesi konseling ini berlaku untuk <strong>seluruh siswa Kelas {{ $namaKelas }}</strong>.
                Putra/putri Anda, <strong>{{ $namaSiswa }}</strong>, termasuk dalam sesi ini.
                Silakan hadir sesuai jadwal yang telah ditentukan.
            @else
                Sesi konseling ini dijadwalkan khusus untuk putra/putri Anda,
                <strong>{{ $namaSiswa }}</strong>. Silakan hadir sesuai jadwal yang telah ditentukan.
            @endif
        </div>

        {{-- Detail Jadwal --}}
        <div class="info-box">
            <table>
                <tr>
                    <td>Nama Siswa</td>
                    <td>: {{ $namaSiswa }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>: {{ $namaKelas }}</td>
                </tr>
                <tr>
                    <td>Topik</td>
                    <td>: {{ $topik }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: {{ $waktu }} WIB</td>
                </tr>
                <tr>
                    <td>Guru Konseling</td>
                    <td>: {{ $namaGuru }}</td>
                </tr>
            </table>
        </div>

        {{-- Catatan --}}
        <div class="note">
            Jika Bapak/Ibu memiliki pertanyaan atau perlu menjadwal ulang, silakan hubungi guru
            melalui fitur <strong>Chat</strong> atau menu <strong>Konseling</strong> di web TK Al-Istiqomah.
        </div>

    </div>

    {{-- ── FOOTER ──────────────────────────────────── --}}
    <div class="footer">
        <p class="school-name">TK Al-Istiqomah</p>
        <p>Email ini dikirim otomatis oleh web TK Al-Istiqomah.</p>
        <p>Mohon tidak membalas email ini.</p>
    </div>

</div>
</body>
</html>
