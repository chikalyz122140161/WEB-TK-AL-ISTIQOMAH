<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Jadwal Konseling</title>
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

        /* Header warna berdasarkan status */
        .header-approved {
            background: linear-gradient(135deg, #2E7D32, #4CAF82);
        }
        .header-rejected {
            background: linear-gradient(135deg, #b71c1c, #ef5350);
        }
        .header {
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
        .status-badge {
            display: inline-block;
            margin-top: 14px;
            background: rgba(255,255,255,0.22);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 6px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.4);
            letter-spacing: 0.5px;
        }

        .body { padding: 28px 32px; }
        .greeting {
            font-size: 15px;
            color: #444;
            margin-bottom: 18px;
            line-height: 1.6;
        }
        .greeting strong { color: #2E7D32; }

        /* Alert box */
        .alert-approved {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-left: 4px solid #2E7D32;
        }
        .alert-rejected {
            background: #ffebee;
            border: 1px solid #ef9a9a;
            border-left: 4px solid #c62828;
        }
        .alert {
            border-radius: 0 8px 8px 0;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            line-height: 1.6;
        }
        .alert-approved p { color: #2E7D32; }
        .alert-rejected p { color: #b71c1c; }
        .alert strong { font-weight: 700; }

        /* Info box */
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
            border-left: 3px solid #90a4ae;
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .note-approved { border-left-color: #4CAF82; }
        .note-rejected { border-left-color: #ef5350; }

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
    @php $isApproved = $status === 'disetujui'; @endphp
    <div class="header {{ $isApproved ? 'header-approved' : 'header-rejected' }}">
        <div class="icon-circle">
            @if ($isApproved)
                {{-- Checkmark icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                </svg>
            @else
                {{-- X icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>
        <h1>TK Al-Istiqomah</h1>
        <p>Notifikasi Jadwal Konseling</p>
        <span class="status-badge">
            {{ $isApproved ? '✓ Disetujui' : '✗ Ditolak' }}
        </span>
    </div>

    {{-- ── BODY ─────────────────────────────────────── --}}
    <div class="body">

        <p class="greeting">
            Yth. Bapak/Ibu <strong>{{ $namaOrtu }}</strong>,<br>
            Berikut adalah informasi mengenai pengajuan jadwal konseling untuk putra/putri Anda.
        </p>

        {{-- Alert Status --}}
        <div class="alert {{ $isApproved ? 'alert-approved' : 'alert-rejected' }}">
            @if ($isApproved)
                <p>
                    Pengajuan jadwal konseling untuk <strong>{{ $namaSiswa }}</strong> telah
                    <strong>disetujui</strong> oleh Guru. Silakan hadir sesuai jadwal yang telah ditentukan.
                </p>
            @else
                <p>
                    Mohon maaf, pengajuan jadwal konseling untuk <strong>{{ $namaSiswa }}</strong> telah
                    <strong>ditolak</strong> oleh Guru. Anda dapat mengajukan jadwal baru melalui web.
                </p>
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
                <tr>
                    <td>Status</td>
                    <td>: <strong>{{ ucfirst($status) }}</strong></td>
                </tr>
            </table>
        </div>

        {{-- Catatan --}}
        <div class="note {{ $isApproved ? 'note-approved' : 'note-rejected' }}">
            @if ($isApproved)
                Jika Bapak/Ibu memiliki pertanyaan lebih lanjut, silakan hubungi guru melalui fitur
                <strong>Chat</strong> di web TK Al-Istiqomah.
            @else
                Untuk mengajukan jadwal konseling baru, silakan masuk ke web dan pilih menu
                <strong>Konseling</strong>. Kami siap membantu putra/putri Anda berkembang.
            @endif
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
