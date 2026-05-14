@extends('layouts.app')

@section('title', 'Jadwal Konseling - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Jadwal Konseling')

@push('styles')
<style>
    /* Toolbar  */
    .toolbar {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .btn-new {
        height: 38px;
        padding: 0 18px;
        background: #3D9B72;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .3px;
        white-space: nowrap;
        transition: background .15s;
    }
    .btn-new:hover { background: #2E8B60; }
    .filter-select {
        height: 38px;
        padding: 0 32px 0 12px;
        font-size: 13px;
        color: #3E2723;
        background: #FFFDE7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236B7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z' clip-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 8px center;
        background-size: 18px;
        border: 1px solid #3E272330;
        border-radius: 8px;
        outline: none;
        appearance: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 140px;
        transition: border-color .15s;
    }
    .filter-select:focus { border-color: #F06292; box-shadow: 0 0 0 3px rgba(251,146,60,.15); }

    /* ── Table card ───────────────────────────────────── */
    .table-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 10px;
        overflow: hidden;
    }
    .jadwal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .jadwal-table thead tr { background: #3D9B72; color: #fff; }
    .jadwal-table thead th {
        padding: 12px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .jadwal-table thead th:first-child { width: 44px; text-align: center; }
    .jadwal-table tbody tr {
        border-bottom: 1px solid #FFFDE7;
        transition: background .1s;
    }
    .jadwal-table tbody tr:last-child { border-bottom: none; }
    .jadwal-table tbody tr:hover { background: #fff7ed; }
    .jadwal-table tbody td {
        padding: 11px 14px;
        color: #3E2723;
        vertical-align: middle;
    }
    .jadwal-table tbody td:first-child { text-align: center; color: #5D4037; font-weight: 600; }

    /* ── Status badges ────────────────────────────────── */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .3px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .badge--disetujui { background: #ffedd5; color: #3E2723; }
    .badge--pending   { background: #FFFDE7; color: #5D4037; border: 1px solid #3E272330; }
    .badge--selesai   { background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%); color: #fff; }
    .badge--tolak     { background: #F0629220; color: #d81b72; }

    /* ── Aksi links ───────────────────────────────────── */
    .aksi-links {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: nowrap;
    }
    .aksi-links a,
    .aksi-links button {
        font-family: inherit;
        border: none;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 5px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .12s;
    }
    .aksi-lihat     { background: rgba(76,175,130,0.12); color: #2E8B60; }
    .aksi-lihat:hover     { background: #4CAF8230; }
    .aksi-edit      { background: #FFFBEB; color: #5D4037; }
    .aksi-edit:hover      { background: #FFF176; }
    .aksi-batalkan  { background: #F0629220; color: #d81b72; }
    .aksi-batalkan:hover  { background: #F0629220; }
    .aksi-setuju    { background: #ffedd5; color: #3E2723; }
    .aksi-setuju:hover    { background: #fed7aa; }
    .aksi-tolak     { background: #F0629220; color: #d81b72; }
    .aksi-tolak:hover     { background: #F0629220; }
    .aksi-catatan   { background: #FFFDE7; color: #3E2723; }
    .aksi-catatan:hover   { background: #3E272320; }

    /* ── Empty state ──────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #5D4037;
        font-size: 14px;
    }


</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    <h2 style="margin:0 0 16px;font-size:20px;font-weight:700;color:#3E2723;text-transform:uppercase;letter-spacing:.5px;">
        Jadwal Konseling
    </h2>

    {{-- Toolbar --}}
    <div class="toolbar">
        <a href="{{ route('guru.jadwal_konseling.create_siswa') }}" class="btn-new" style="text-decoration:none;display:inline-flex;align-items:center;gap:6px;line-height:38px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
            BUAT JADWAL PER SISWA
        </a>
        <a href="{{ route('guru.jadwal_konseling.create_kelas') }}" class="btn-new" style="text-decoration:none;display:inline-flex;align-items:center;gap:6px;line-height:38px;background:#2E8B60;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 0 0 3 3h15a.75.75 0 0 0 0-1.5h-15a1.5 1.5 0 0 1-1.5-1.5V4.875c0-.207.168-.375.375-.375h15.75c.207 0 .375.168.375.375V12a.75.75 0 0 0 1.5 0V4.875C21.75 3.839 20.911 3 19.875 3H4.125Z" clip-rule="evenodd"/><path d="M16.5 16.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
            BUAT JADWAL PER KELAS
        </a>
        <form method="GET" action="{{ route('guru.jadwal_konseling') }}" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-left:auto;">
            <input
                class="filter-select"
                type="month"
                name="bulan_tahun"
                value="{{ request('bulan_tahun', date('Y-m')) }}"
                style="min-width:160px;padding:0 12px;"
            >
            <button type="submit" class="btn-new">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <table class="jadwal-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Dari</th>
                    <th>Orang Tua</th>
                    <th>Siswa</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwal as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row['tanggal'] }}</td>
                    <td style="white-space:nowrap;">{{ $row['waktu'] }}</td>
                    <td>
                        @php $dari = $row['dari'] ?? 'guru'; @endphp
                        @if ($dari === 'orang_tua')
                            <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:99px;background:#FFF176;color:#5D4037;border:1px solid #e6db00;white-space:nowrap;">
                                ORANG TUA
                            </span>
                        @else
                            <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:99px;background:rgba(76,175,130,0.15);color:#2E8B60;border:1px solid rgba(76,175,130,0.4);white-space:nowrap;">
                                GURU
                            </span>
                        @endif
                    </td>
                    <td>{{ $row['orang_tua'] }}</td>
                    <td>{{ $row['siswa'] }}</td>
                    <td>{{ $row['topik'] }}</td>
                    <td>
                        @if ($row['status'] === 'disetujui')
                            <span class="badge badge--disetujui">Disetujui</span>
                        @elseif ($row['status'] === 'pending')
                            <span class="badge badge--pending">Pending</span>
                        @elseif ($row['status'] === 'selesai')
                            <span class="badge badge--selesai">Selesai</span>
                        @else
                            <span class="badge badge--tolak">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <div class="aksi-links">
                            <a href="{{ route('guru.jadwal_konseling.show', $row['id']) }}" class="aksi-lihat">[LIHAT]</a>
                            @if ($row['status'] === 'disetujui')
                                <a href="{{ route('guru.jadwal_konseling.edit', $row['id']) }}" class="aksi-edit">[EDIT]</a>
                                <button type="button" class="aksi-batalkan"
                                    onclick="showBatalkanModal({{ $row['id'] }}, '{{ addslashes($row['siswa']) }}', '{{ addslashes($row['tanggal']) }}', '{{ addslashes($row['waktu']) }}')">[BATALKAN]</button>
                            @elseif ($row['status'] === 'pending')
                                <button type="button" class="aksi-setuju"
                                    onclick="showSetujuModal({{ $row['id'] }}, '{{ addslashes($row['siswa']) }}', '{{ addslashes($row['tanggal']) }}', '{{ addslashes($row['waktu']) }}')">[SETUJU]</button>
                                <button type="button" class="aksi-tolak"
                                    onclick="showTolakModal({{ $row['id'] }}, '{{ addslashes($row['siswa']) }}', '{{ addslashes($row['tanggal']) }}', '{{ addslashes($row['waktu']) }}')">[TOLAK]</button>
                            @elseif ($row['status'] === 'selesai')
                                <a href="{{ route('guru.jadwal_konseling.show', $row['id']) }}" class="aksi-catatan">[CATATAN]</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">Belum ada jadwal konseling bulan ini.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Setujui --}}
    <div id="setujuModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon modal-icon--success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="modal-title">Setujui Jadwal Konseling?</h3>
            <p class="modal-desc">
                Apakah Anda yakin ingin menyetujui jadwal konseling
                <strong id="setujuSiswa"></strong> pada <strong id="setujuTanggal"></strong>
                pukul <strong id="setujuWaktu"></strong>?
            </p>
            <form id="setujuForm" method="POST">
                @csrf
                <div class="modal-actions">
                    <button type="button" class="btn btn--ghost" onclick="closeSetujuModal()">Batal</button>
                    <button type="submit" class="btn btn--primary">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div id="tolakModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon modal-icon--danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
            </div>
            <h3 class="modal-title">Tolak Jadwal Konseling?</h3>
            <p class="modal-desc">
                Apakah Anda yakin ingin menolak jadwal konseling
                <strong id="tolakSiswa"></strong> pada <strong id="tolakTanggal"></strong>?
            </p>
            <form id="tolakForm" method="POST">
                @csrf
                <textarea name="alasan" class="form-textarea" rows="3" placeholder="Alasan penolakan (opsional)..."
                    style="width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-family:inherit;font-size:13px;color:var(--text);background:#fff;margin-bottom:16px;resize:vertical;"></textarea>
                <div class="modal-actions">
                    <button type="button" class="btn btn--ghost" onclick="closeTolakModal()">Batal</button>
                    <button type="submit" class="btn btn--danger">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Batalkan --}}
    <div id="batalkanModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon modal-icon--warning">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
            </div>
            <h3 class="modal-title">Batalkan Jadwal Konseling?</h3>
            <p class="modal-desc">
                Apakah Anda yakin ingin membatalkan jadwal konseling
                <strong id="batalkanSiswa"></strong> pada <strong id="batalkanTanggal"></strong>
                pukul <strong id="batalkanWaktu"></strong>?
            </p>
            <form id="batalkanForm" method="POST">
                @csrf
                <div class="modal-actions">
                    <button type="button" class="btn btn--ghost" onclick="closeBatalkanModal()">Batal</button>
                    <button type="submit" class="btn btn--danger">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Setuju Modal
        function showSetujuModal(id, siswa, tanggal, waktu) {
            document.getElementById('setujuSiswa').textContent   = siswa;
            document.getElementById('setujuTanggal').textContent = tanggal;
            document.getElementById('setujuWaktu').textContent   = waktu;
            document.getElementById('setujuForm').action         = "{{ url('guru/jadwal-konseling') }}/" + id + "/setuju";
            document.getElementById('setujuModal').classList.add('active');
        }
        function closeSetujuModal() {
            document.getElementById('setujuModal').classList.remove('active');
        }

        // Tolak Modal
        function showTolakModal(id, siswa, tanggal, waktu) {
            document.getElementById('tolakSiswa').textContent    = siswa;
            document.getElementById('tolakTanggal').textContent  = tanggal;
            document.getElementById('tolakForm').action          = "{{ url('guru/jadwal-konseling') }}/" + id + "/tolak";
            document.getElementById('tolakModal').classList.add('active');
        }
        function closeTolakModal() {
            document.getElementById('tolakModal').classList.remove('active');
        }

        // Batalkan Modal
        function showBatalkanModal(id, siswa, tanggal, waktu) {
            document.getElementById('batalkanSiswa').textContent   = siswa;
            document.getElementById('batalkanTanggal').textContent = tanggal;
            document.getElementById('batalkanWaktu').textContent   = waktu;
            document.getElementById('batalkanForm').action         = "{{ url('guru/jadwal-konseling') }}/" + id + "/batalkan";
            document.getElementById('batalkanModal').classList.add('active');
        }
        function closeBatalkanModal() {
            document.getElementById('batalkanModal').classList.remove('active');
        }

        // Close modals when clicking outside
        ['setujuModal', 'tolakModal', 'batalkanModal'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                el.addEventListener('click', function(e) {
                    if (e.target === this) this.classList.remove('active');
                });
            }
        });
    </script>

@endsection
