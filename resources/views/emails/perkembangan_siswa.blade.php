<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perkembangan Siswa</title>
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
            background: linear-gradient(135deg, #2E7D32, #4CAF82);
            padding: 30px 32px;
            text-align: center;
        }
        .header .logo-circle {
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
        .badge-minggu {
            display: inline-block;
            margin-top: 14px;
            background: rgba(255,255,255,0.22);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            padding: 5px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.35);
        }
        .body {
            padding: 28px 32px;
        }
        .greeting {
            font-size: 15px;
            color: #444;
            margin-bottom: 14px;
        }
        .greeting strong {
            color: #2E7D32;
        }
        .info-box {
            background: #f0faf4;
            border: 1px solid #c8e6c9;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 22px;
        }
        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-box td {
            padding: 5px 0;
            font-size: 13.5px;
            vertical-align: top;
        }
        .info-box td:first-child {
            color: #555;
            width: 38%;
            font-weight: 500;
        }
        .info-box td:last-child {
            color: #222;
            font-weight: 600;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #2E7D32;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #c8e6c9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .penilaian-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 13.5px;
        }
        .penilaian-table thead tr {
            background: #e8f5e9;
        }
        .penilaian-table th {
            padding: 10px 12px;
            text-align: left;
            font-weight: 700;
            color: #2E7D32;
            border-bottom: 2px solid #c8e6c9;
        }
        .penilaian-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
        }
        .penilaian-table tr:last-child td {
            border-bottom: none;
        }
        .penilaian-table tr:nth-child(even) td {
            background: #fafafa;
        }
        .level-badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
        }
        .level-BB  { background: #ffebee; color: #c62828; }
        .level-MB  { background: #fff3e0; color: #e65100; }
        .level-BSH { background: #e3f2fd; color: #1565c0; }
        .level-BSB { background: #e8f5e9; color: #2E7D32; }
        .level-desc {
            margin-bottom: 20px;
            background: #fffde7;
            border: 1px solid #fff176;
            border-radius: 8px;
            padding: 12px 16px;
        }
        .level-desc p {
            font-size: 12.5px;
            color: #555;
            margin-bottom: 4px;
        }
        .level-desc p:last-child { margin-bottom: 0; }
        .level-desc span {
            display: inline-block;
            width: 38px;
            font-weight: 700;
        }
        .note {
            font-size: 13px;
            color: #666;
            background: #fafafa;
            border-left: 3px solid #4CAF82;
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 24px;
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
        <div class="logo-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 24 24">
                <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.174v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/>
                <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.71 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.44.121-2.87.255-4.284a48.473 48.473 0 0 1 7.666 3.282c.233.128.49.192.75.192Z"/>
            </svg>
        </div>
        <h1>TK Al-Istiqomah</h1>
        <p>Laporan Perkembangan Siswa</p>
        <span class="badge-minggu">Minggu ke-{{ $mingguKe }} &bull; {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span>
    </div>

    {{-- ── BODY ─────────────────────────────────────── --}}
    <div class="body">

        <p class="greeting">
            Yth. Bapak/Ibu <strong>{{ $namaOrtu }}</strong>,<br>
            Berikut adalah laporan perkembangan putra/putri Anda:
        </p>

        {{-- Info Siswa --}}
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
                    <td>Tahun Ajaran</td>
                    <td>: {{ $tahunAjaran }} — {{ ucfirst($semester) }}</td>
                </tr>
                <tr>
                    <td>Minggu ke-</td>
                    <td>: {{ $mingguKe }}</td>
                </tr>
                <tr>
                    <td>Tanggal Input</td>
                    <td>: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Guru</td>
                    <td>: {{ $namaGuru }}</td>
                </tr>
            </table>
        </div>

        {{-- Tabel Penilaian --}}
        @if (!empty($hasilPenilaian))
            <div class="section-title">Hasil Penilaian Perkembangan</div>
            <table class="penilaian-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aspek Konseling</th>
                        <th>Indikator</th>
                        <th>Capaian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasilPenilaian as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item['konseling'] }}</td>
                            <td>{{ $item['aspek'] }}</td>
                            <td>
                                <span class="level-badge level-{{ $item['level'] }}">
                                    {{ $item['level'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Keterangan Level --}}
            <div class="level-desc">
                <p><span>BB</span> Belum Berkembang</p>
                <p><span>MB</span> Mulai Berkembang</p>
                <p><span>BSH</span> Berkembang Sesuai Harapan</p>
                <p><span>BSB</span> Berkembang Sangat Baik</p>
            </div>
        @else
            <p style="color:#999; font-size:13px; margin-bottom:20px;">Tidak ada data penilaian untuk minggu ini.</p>
        @endif

        {{-- Catatan --}}
        <div class="note">
            Jika Bapak/Ibu memiliki pertanyaan mengenai perkembangan anak, silakan menghubungi guru melalui fitur
            <strong>Chat</strong> atau mengajukan sesi <strong>Konseling</strong> di web TK Al-Istiqomah.
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
