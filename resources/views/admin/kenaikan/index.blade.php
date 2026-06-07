@extends('layouts.app')

@section('title', 'Kenaikan Siswa - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Kenaikan Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
    <style>
        .alert-success {
            background: rgba(76, 175, 130, 0.12);
            border: 1px solid rgba(76, 175, 130, 0.3);
            color: #2E8B60;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .alert-success svg {
            flex-shrink: 0;
        }

        .section-header {
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 15px;
            font-weight: 600;
            color: #3E2723;
            margin: 0 0 4px;
        }

        .section-header p {
            font-size: 13px;
            color: #78716c;
            margin: 0;
        }

        /* Toolbar */
        .table-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 320px;
        }

        .search-wrap svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            fill: rgba(62, 39, 35, 0.4);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            height: 38px;
            padding: 0 12px 0 36px;
            font-size: 13px;
            border: 1px solid rgba(62, 39, 35, 0.15);
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: #3E2723;
            box-sizing: border-box;
            transition: border-color .12s, box-shadow .12s;
        }

        .search-input:focus {
            border-color: #4CAF82;
            box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.12);
        }

        .filter-select {
            height: 38px;
            padding: 0 24px 0 12px;
            font-size: 13px;
            border: 1px solid rgba(62, 39, 35, 0.15);
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: #3E2723;
            cursor: pointer;
            box-sizing: border-box;
            transition: border-color .12s, box-shadow .12s;
        }

        .filter-select:focus {
            border-color: #4CAF82;
            box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.12);
        }

        .filter-select--tahun {
            min-width: 150px;
        }

        .filter-select--semester {
            min-width: 130px;
        }

        .filter-select--status {
            min-width: 150px;
        }

        /* ── Teks Jumlah Hasil ── */
        .result-count {
            font-size: 12px;
            color: #7c7471;
            margin-left: auto;
            white-space: nowrap;
            font-weight: 500;
        }

        /* ── Responsivitas Mobile ── */
        @media (max-width: 768px) {
            .table-toolbar {
                gap: 8px;
            }

            .search-wrap {
                max-width: 100%;
                flex-shrink: 0;
            }

            .filter-select {
                flex: 1 1 calc(50% - 4px);
                min-width: 0;
            }

            .filter-select--status {
                flex: 1 1 100%;
            }

            .result-count {
                margin-left: 0;
                width: 100%;
                padding-top: 4px;
                text-align: right;
            }
        }

        /* Table */
        .table-wrap {
            background: #fff;
            border: 1px solid #e7e5e4;
            border-radius: 10px;
            overflow-x: scroll;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table thead th {
            background: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 11px 14px;
            text-align: left;
            border-bottom: 1px solid #e7e5e4;
            white-space: nowrap;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #f5f5f4;
            transition: background 0.15s;
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .data-table tbody td {
            padding: 11px 14px;
            color: #3E2723;
            vertical-align: middle;
        }

        .kelas-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        .status-pill {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: capitalize;
            display: inline-block;
        }

        .status-pill--aktif {
            background: rgba(76, 175, 130, 0.15);
            color: #2E8B60;
        }

        .status-pill--selesai {
            background: rgba(62, 39, 35, 0.08);
            color: #5D4037;
        }

        .status-pill--menunggu {
            background: #FFF176;
            color: #5D4037;
        }

        .ispass-pill {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .ispass-pill--true {
            background: rgba(62, 39, 35, 0.08);
            color: #5D4037;
        }

        .ispass-pill--false {
            background: rgba(76, 175, 130, 0.15);
            color: #2E8B60;
        }

        .siswa-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #78716c;
        }

        .siswa-count svg {
            width: 14px;
            height: 14px;
            fill: #a8a29e;
        }

        .btn-proses {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            color: #fff;
            padding: 6px 13px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 7px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(61, 155, 114, 0.25);
            white-space: nowrap;
        }

        .btn-proses:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(61, 155, 114, 0.35);
        }

        .btn-proses svg {
            width: 13px;
            height: 13px;
            fill: currentColor;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #FFF176;
            color: #5D4037;
            border: 1px solid #e6db00;
            padding: 6px 13px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 7px;
            text-decoration: none;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: #f9ed50;
        }

        .btn-detail svg {
            width: 13px;
            height: 13px;
            fill: currentColor;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a8a29e;
            cursor: not-allowed;

        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            fill: #d6d3d1;
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }

        .no-results {
            text-align: center;
            padding: 40px 20px;
            color: #a8a29e;
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="section-header">
        <h2>Riwayat Kelas & Pembelajaran</h2>
        <p>Daftar kelas dengan status <strong>Selesai</strong> menampilkan riwayat kehadiran dan pendaftaran per siswa.</p>
    </div>

    @if ($grouped->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                    clip-rule="evenodd" />
            </svg>
            <p>Belum ada class term.</p>
        </div>
    @else
        @php
            $tahunList = $grouped->keys()->sort()->values();
        @endphp
        <div class="table-toolbar">
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                        clip-rule="evenodd" />
                </svg>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari kelas...">
            </div>

            <select id="filterTahun" class="filter-select filter-select--tahun">
                <option value="">Semua Tahun Ajaran</option>
                @foreach ($tahunList as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>

            <select id="filterSemester" class="filter-select filter-select--semester">
                <option value="">Semua Semester</option>
                <option value="ganjil">Ganjil</option>
                <option value="genap">Genap</option>
            </select>

            <select id="filterIsPass" class="filter-select filter-select--status">
                <option value="">Semua Status</option>
                <option value="false">Sedang Berjalan</option>
                <option value="true">Selesai</option>
            </select>

            <span class="result-count" id="resultCount"></span>
        </div>

        <div class="table-wrap">
            <table class="data-table" id="kenaikanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Kenaikan</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @php $no = 1; @endphp
                    @foreach ($grouped as $tahunAjaran => $terms)
                        @foreach ($terms as $ct)
                            <tr data-search="{{ strtolower($ct['kelas_nama'] . ' ' . $ct['tahun_ajaran'] . ' ' . $ct['semester']) }}"
                                data-kelas="{{ strtolower($ct['kelas_nama']) }}" data-tahun="{{ $ct['tahun_ajaran'] }}"
                                data-semester="{{ $ct['semester'] }}" data-ispass="{{ $ct['isPass'] ? 'true' : 'false' }}">
                                <td>{{ $no++ }}</td>
                                <td><span class="kelas-badge">{{ $ct['kelas_nama'] }}</span></td>
                                <td>{{ $ct['tahun_ajaran'] }}</td>
                                <td>{{ ucfirst($ct['semester']) }}</td>
                                <td>
                                    <span class="status-pill status-pill--{{ $ct['status'] }}">
                                        {{ ucfirst($ct['status']) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="ispass-pill ispass-pill--{{ $ct['isPass'] ? 'true' : 'false' }}">
                                        {{ $ct['isPass'] ? 'Selesai' : 'Sedang Berjalan' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="siswa-count">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z" />
                                            <path
                                                d="M6 16.5a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Zm9.75 0a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Z" />
                                        </svg>
                                        {{ $ct['jumlah_siswa'] }} siswa
                                    </span>
                                </td>
                                <td>
                                    @if ($ct['isPass'])
                                        <a href="{{ route('admin.kenaikan.detail', $ct['id']) }}" class="btn-detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path fill-rule="evenodd"
                                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Lihat Detail
                                        </a>
                                    @elseif ($ct['status'] === 'aktif')
                                        <a href="{{ route('admin.kenaikan.show', $ct['id']) }}" class="btn-proses">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Proses Kenaikan
                                        </a>
                                    @else
                                        <span style="color:#a8a29e;font-size:12px;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="no-results" id="noResults" style="display:none;">
                Tidak ada data yang cocok dengan pencarian.
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        (function() {
            const searchInput = document.getElementById('searchInput');
            const filterTahun = document.getElementById('filterTahun');
            const filterSemester = document.getElementById('filterSemester');
            const filterIsPass = document.getElementById('filterIsPass');
            const tableBody = document.getElementById('tableBody');
            const noResults = document.getElementById('noResults');
            const resultCount = document.getElementById('resultCount');

            if (!tableBody) return;

            const allRows = Array.from(tableBody.querySelectorAll('tr'));
            const total = allRows.length;

            function applyFilters() {
                const keyword = searchInput.value.toLowerCase().trim();
                const tahun = filterTahun.value;
                const semester = filterSemester.value;
                const ispass = filterIsPass.value;
                let visible = 0;

                allRows.forEach(function(row) {
                    const rowSearch = row.dataset.search || '';
                    const rowTahun = row.dataset.tahun || '';
                    const rowSemester = row.dataset.semester || '';
                    const rowIsPass = row.dataset.ispass || '';

                    const matchSearch = !keyword || rowSearch.includes(keyword);
                    const matchTahun = !tahun || rowTahun === tahun;
                    const matchSemester = !semester || rowSemester === semester;
                    const matchIsPass = !ispass || rowIsPass === ispass;

                    if (matchSearch && matchTahun && matchSemester && matchIsPass) {
                        row.style.display = '';
                        visible++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                noResults.style.display = visible === 0 ? 'block' : 'none';
                resultCount.textContent = visible + ' dari ' + total + ' data';

                let no = 1;
                allRows.forEach(function(row) {
                    if (row.style.display !== 'none') {
                        row.cells[0].textContent = no++;
                    }
                });
            }

            searchInput.addEventListener('input', applyFilters);
            filterTahun.addEventListener('change', applyFilters);
            filterSemester.addEventListener('change', applyFilters);
            filterIsPass.addEventListener('change', applyFilters);

            applyFilters();
        })();
    </script>
@endpush
