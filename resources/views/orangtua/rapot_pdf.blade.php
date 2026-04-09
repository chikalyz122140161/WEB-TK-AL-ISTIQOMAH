<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapot Semester - {{ $rapot['siswa']['nama'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }
        
        /* Header */
        .header {
            text-align: center;
            border-bottom: 3px double #3E2723;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            color: #3E2723;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 20px;
            color: #3E2723;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        /* Info Box */
        .info-box {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 120px;
            font-weight: bold;
            color: #3E2723;
        }
        .info-table td:nth-child(2) {
            width: 10px;
        }
        
        /* Section */
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background: #3E2723;
            color: #fff;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        /* Nilai Table */
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .nilai-table th,
        .nilai-table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        .nilai-table th {
            background: #FFFDE7;
            font-weight: bold;
            color: #3E2723;
            font-size: 10px;
        }
        .nilai-table td {
            font-size: 10px;
        }
        .nilai-table .aspek {
            width: 150px;
            font-weight: bold;
        }
        .nilai-table .capaian {
            width: 60px;
            text-align: center;
            font-weight: bold;
        }
        .capaian-bb { color: #dc3545; }
        .capaian-mb { color: #fd7e14; }
        .capaian-bsh { color: #28a745; }
        .capaian-bsb { color: #007bff; }
        
        /* Kehadiran */
        .kehadiran-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kehadiran-table th,
        .kehadiran-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .kehadiran-table th {
            background: #FFFDE7;
            font-weight: bold;
            color: #3E2723;
        }
        .kehadiran-table td {
            font-size: 14px;
            font-weight: bold;
        }
        
        /* Legend */
        .legend {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            margin-top: 15px;
        }
        .legend-title {
            font-weight: bold;
            font-size: 10px;
            color: #3E2723;
            margin-bottom: 8px;
        }
        .legend-items {
            display: flex;
            flex-wrap: wrap;
        }
        .legend-item {
            margin-right: 20px;
            font-size: 9px;
        }
        
        /* Catatan Box */
        .catatan-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 10px;
        }
        .catatan-label {
            font-weight: bold;
            color: #3E2723;
            font-size: 10px;
            margin-bottom: 5px;
        }
        .catatan-text {
            font-size: 10px;
            line-height: 1.6;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-area {
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .signature-box p {
            font-size: 10px;
            margin-bottom: 60px;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 0 auto;
            padding-top: 5px;
            font-size: 10px;
        }
        
        /* Page break for print */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>TK AL-ISTIQOMAH</h1>
        <h2>LAPORAN PERKEMBANGAN ANAK DIDIK</h2>
        <p>Semester {{ $rapot['semester'] }} - Tahun Ajaran {{ $rapot['tahun_ajaran'] }}</p>
    </div>
    
    {{-- Info Siswa --}}
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td>{{ $rapot['siswa']['nama'] }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $rapot['kelas'] }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>:</td>
                <td>{{ $rapot['semester'] }}</td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td>{{ $rapot['tahun_ajaran'] }}</td>
            </tr>
        </table>
    </div>
    
    {{-- Capaian Perkembangan --}}
    <div class="section">
        <div class="section-title">CAPAIAN PERKEMBANGAN ANAK</div>
        <table class="nilai-table">
            <thead>
                <tr>
                    <th class="aspek">Aspek Perkembangan</th>
                    <th class="capaian">Capaian</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="aspek">Nilai Agama & Moral</td>
                    <td class="capaian capaian-{{ strtolower($rapot['nilai']['agama_moral']) }}">{{ $rapot['nilai']['agama_moral'] }}</td>
                    <td>{{ $rapot['nilai']['agama_moral_deskripsi'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="aspek">Fisik Motorik</td>
                    <td class="capaian capaian-{{ strtolower($rapot['nilai']['fisik_motorik']) }}">{{ $rapot['nilai']['fisik_motorik'] }}</td>
                    <td>{{ $rapot['nilai']['fisik_motorik_deskripsi'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="aspek">Kognitif</td>
                    <td class="capaian capaian-{{ strtolower($rapot['nilai']['kognitif']) }}">{{ $rapot['nilai']['kognitif'] }}</td>
                    <td>{{ $rapot['nilai']['kognitif_deskripsi'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="aspek">Bahasa</td>
                    <td class="capaian capaian-{{ strtolower($rapot['nilai']['bahasa']) }}">{{ $rapot['nilai']['bahasa'] }}</td>
                    <td>{{ $rapot['nilai']['bahasa_deskripsi'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="aspek">Sosial Emosional</td>
                    <td class="capaian capaian-{{ strtolower($rapot['nilai']['sosial_emosional']) }}">{{ $rapot['nilai']['sosial_emosional'] }}</td>
                    <td>{{ $rapot['nilai']['sosial_emosional_deskripsi'] ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="aspek">Seni</td>
                    <td class="capaian capaian-{{ strtolower($rapot['nilai']['seni']) }}">{{ $rapot['nilai']['seni'] }}</td>
                    <td>{{ $rapot['nilai']['seni_deskripsi'] ?: '-' }}</td>
                </tr>
            </tbody>
        </table>
        
        <div class="legend">
            <div class="legend-title">Keterangan Capaian:</div>
            <table style="width: 100%; font-size: 9px;">
                <tr>
                    <td style="width: 25%;"><strong>BB</strong> = Belum Berkembang</td>
                    <td style="width: 25%;"><strong>MB</strong> = Mulai Berkembang</td>
                    <td style="width: 25%;"><strong>BSH</strong> = Berkembang Sesuai Harapan</td>
                    <td style="width: 25%;"><strong>BSB</strong> = Berkembang Sangat Baik</td>
                </tr>
            </table>
        </div>
    </div>
    
    {{-- Kehadiran --}}
    <div class="section">
        <div class="section-title">REKAP KEHADIRAN</div>
        <table class="kehadiran-table">
            <thead>
                <tr>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpa</th>
                    <th>Total Hari Efektif</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $rapot['kehadiran']['hadir'] }} hari</td>
                    <td>{{ $rapot['kehadiran']['izin'] }} hari</td>
                    <td>{{ $rapot['kehadiran']['sakit'] }} hari</td>
                    <td>{{ $rapot['kehadiran']['alpa'] }} hari</td>
                    <td>{{ $rapot['kehadiran']['hadir'] + $rapot['kehadiran']['izin'] + $rapot['kehadiran']['sakit'] + $rapot['kehadiran']['alpa'] }} hari</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    {{-- Catatan --}}
    <div class="section">
        <div class="section-title">CATATAN & REKOMENDASI</div>
        <div class="catatan-box">
            <div class="catatan-label">Catatan Guru:</div>
            <div class="catatan-text">{{ $rapot['catatan_guru'] ?: 'Tidak ada catatan.' }}</div>
        </div>
        <div class="catatan-box">
            <div class="catatan-label">Rekomendasi:</div>
            <div class="catatan-text">{{ $rapot['rekomendasi'] ?: 'Tidak ada rekomendasi.' }}</div>
        </div>
    </div>
    
    {{-- Tanda Tangan --}}
    <div class="footer">
        <div class="signature-area">
            <div class="signature-box">
                <p>Orang Tua/Wali</p>
                <div class="signature-line">
                    (................................)
                </div>
            </div>
            <div class="signature-box">
                <p>Guru Kelas</p>
                <div class="signature-line">
                    {{ $rapot['guru'] }}
                </div>
            </div>
            <div class="signature-box">
                <p>Kepala Sekolah</p>
                <div class="signature-line">
                    (................................)
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 20px; font-size: 10px;">
            <p>Diterbitkan pada: {{ $rapot['tanggal_terbit'] }}</p>
        </div>
    </div>
</body>
</html>
