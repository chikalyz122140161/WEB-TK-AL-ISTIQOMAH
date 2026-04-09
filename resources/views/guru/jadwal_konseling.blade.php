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
    .filter-select:focus { border-color: #fb923c; box-shadow: 0 0 0 3px rgba(251,146,60,.15); }

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
    .badge--disetujui { background: #ffedd5; color: #c2410c; }
    .badge--pending   { background: #FFFDE7; color: #5D4037; border: 1px solid #3E272330; }
    .badge--selesai   { background: #3E2723; color: #FFFDE7; }
    .badge--tolak     { background: #FEE2E2; color: #B91C1C; }

    /* ── Aksi links ───────────────────────────────────── */
    .aksi-links {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: nowrap;
    }
    .aksi-links a {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 5px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .12s;
    }
    .aksi-lihat     { background: #ecfdf5; color: #2E8B60; }
    .aksi-lihat:hover     { background: #d1fae5; }
    .aksi-edit      { background: #FFFBEB; color: #5D4037; }
    .aksi-edit:hover      { background: #FFF176; }
    .aksi-batalkan  { background: #FEF2F2; color: #B91C1C; }
    .aksi-batalkan:hover  { background: #FEE2E2; }
    .aksi-setuju    { background: #ffedd5; color: #c2410c; }
    .aksi-setuju:hover    { background: #fed7aa; }
    .aksi-tolak     { background: #FEF2F2; color: #B91C1C; }
    .aksi-tolak:hover     { background: #FEE2E2; }
    .aksi-catatan   { background: #FFFDE7; color: #3E2723; }
    .aksi-catatan:hover   { background: #3E272320; }

    /* ── Empty state ──────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #5D4037;
        font-size: 14px;
    }

    /* ── Modal (Buat Jadwal Baru) ─────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: #fff;
        border-radius: 12px;
        padding: 28px 32px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal__title {
        font-size: 16px;
        font-weight: 700;
        color: #3E2723;
        margin: 0 0 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #FFFDE7;
        text-transform: uppercase;
        letter-spacing: .3px;
    }
    .field-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
    .field-label {
        font-size: 11px;
        font-weight: 700;
        color: #5D4037;
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .field-control {
        width: 100%;
        height: 40px;
        padding: 0 12px;
        font-size: 13px;
        color: #3E2723;
        background: #FFFDE7;
        border: 1px solid #3E272320;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color .15s;
    }
    .field-control:focus { border-color: #63E6BE; background: #fff; box-shadow: 0 0 0 3px rgba(99,230,190,.15); }
    .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
    .btn-modal-save {
        flex: 1;
        height: 38px;
        background: #065F46;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-save:hover { background: #064E3B; }
    .btn-modal-cancel {
        height: 38px;
        padding: 0 20px;
        background: #fff;
        color: #3E2723;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #3E272330;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-cancel:hover { background: #FFFDE7; }
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
    <form method="GET" action="{{ route('guru.jadwal_konseling') }}" class="toolbar">
        <button type="button" class="btn-new" onclick="document.getElementById('modalBuat').classList.add('open')">
            BUAT JADWAL BARU
        </button>
        <input
            class="filter-select"
            type="month"
            name="bulan_tahun"
            value="{{ request('bulan_tahun', date('Y-m')) }}"
            style="min-width:160px;padding:0 12px;"
        >
        <button type="submit" class="btn-new" style="background:#3E2723;">FILTER</button>
    </form>

    {{-- Table --}}
    <div class="table-card">
        <table class="jadwal-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
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
                                <a href="javascript:void(0)" class="aksi-batalkan"
                                    onclick="showConfirmModal('batalkan', {{ $row['id'] }}, '{{ addslashes($row['siswa']) }}', '{{ addslashes($row['tanggal']) }}', '{{ addslashes($row['waktu']) }}')">[BATALKAN]</a>
                            @elseif ($row['status'] === 'pending')
                                <a href="javascript:void(0)" class="aksi-setuju"
                                    onclick="showConfirmModal('setuju', {{ $row['id'] }}, '{{ addslashes($row['siswa']) }}', '{{ addslashes($row['tanggal']) }}', '{{ addslashes($row['waktu']) }}')">[SETUJU]</a>
                                <a href="javascript:void(0)" class="aksi-tolak"
                                    onclick="showConfirmModal('tolak', {{ $row['id'] }}, '{{ addslashes($row['siswa']) }}', '{{ addslashes($row['tanggal']) }}', '{{ addslashes($row['waktu']) }}')">[TOLAK]</a>
                            @elseif ($row['status'] === 'selesai')
                                <a href="{{ route('guru.jadwal_konseling.show', $row['id']) }}" class="aksi-catatan">[CATATAN]</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">Belum ada jadwal konseling bulan ini.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Buat Jadwal Baru --}}
    <div class="modal-overlay" id="modalBuat" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <p class="modal__title">Buat Jadwal Baru</p>
            <form method="POST" action="{{ route('guru.store_jadwal_konseling') }}">
                @csrf
                <div class="field-group">
                    <label class="field-label" for="m_tanggal">Tanggal</label>
                    <input class="field-control" type="date" id="m_tanggal" name="tanggal" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_waktu_mulai">Waktu Mulai</label>
                    <input class="field-control" type="time" id="m_waktu_mulai" name="waktu_mulai" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_waktu_selesai">Waktu Selesai</label>
                    <input class="field-control" type="time" id="m_waktu_selesai" name="waktu_selesai" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_orang_tua">Orang Tua</label>
                    <select class="field-control" id="m_orang_tua" name="orang_tua" required>
                        <option value="" disabled selected>-- Pilih Orang Tua --</option>
                        @foreach ($daftarOrangTua as $ot)
                            <option value="{{ $ot['nama'] }}">{{ $ot['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_siswa">Siswa</label>
                    <select class="field-control" id="m_siswa" name="siswa" required>
                        <option value="" disabled selected>-- Pilih Siswa --</option>
                        @foreach ($daftarSiswa as $s)
                            <option value="{{ $s['nama'] }}">{{ $s['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_topik">Topik</label>
                    <input class="field-control" type="text" id="m_topik" name="topik" placeholder="Topik konseling" required>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-modal-save">SIMPAN</button>
                    <button type="button" class="btn-modal-cancel"
                        onclick="document.getElementById('modalBuat').classList.remove('open')">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Setujui --}}
    <div class="modal-overlay" id="modalSetuju" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <p class="modal__title" style="font-size:32px;margin:0 0 6px;text-align:center;">✅</p>
            <p class="modal__title">Setujui Jadwal Konseling?</p>
            <p style="font-size:13px;color:#5D4037;text-align:center;margin:0 0 20px;line-height:1.6;">
                Jadwal konseling <strong id="setujuSiswa"></strong> pada <strong id="setujuTanggal"></strong>
                pukul <strong id="setujuWaktu"></strong> akan disetujui.
            </p>
            <form method="POST" id="formSetuju" action="">
                @csrf
                <div class="modal-actions">
                    <button type="submit" class="btn-modal-save" style="background:linear-gradient(135deg,#3D9B72,#2E8B60);">Ya, Setujui</button>
                    <button type="button" class="btn-modal-cancel" onclick="document.getElementById('modalSetuju').classList.remove('open')">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div class="modal-overlay" id="modalTolak" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <p class="modal__title" style="font-size:32px;margin:0 0 6px;text-align:center;">❌</p>
            <p class="modal__title">Tolak Jadwal Konseling?</p>
            <p style="font-size:13px;color:#5D4037;text-align:center;margin:0 0 20px;line-height:1.6;">
                Jadwal konseling <strong id="tolakSiswa"></strong> pada <strong id="tolakTanggal"></strong>
                akan ditolak. Tindakan ini tidak bisa dibatalkan.
            </p>
            <form method="POST" id="formTolak" action="">
                @csrf
                <div class="modal-actions">
                    <button type="submit" class="btn-modal-save" style="background:#B91C1C;">Ya, Tolak</button>
                    <button type="button" class="btn-modal-cancel" onclick="document.getElementById('modalTolak').classList.remove('open')">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Batalkan --}}
    <div class="modal-overlay" id="modalBatalkan" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <p class="modal__title" style="font-size:32px;margin:0 0 6px;text-align:center;">⚠️</p>
            <p class="modal__title">Batalkan Jadwal Konseling?</p>
            <p style="font-size:13px;color:#5D4037;text-align:center;margin:0 0 20px;line-height:1.6;">
                Jadwal konseling <strong id="batalkanSiswa"></strong> pada <strong id="batalkanTanggal"></strong>
                pukul <strong id="batalkanWaktu"></strong> akan dibatalkan.
            </p>
            <form method="POST" id="formBatalkan" action="">
                @csrf
                <div class="modal-actions">
                    <button type="submit" class="btn-modal-save" style="background:#B91C1C;">Ya, Batalkan</button>
                    <button type="button" class="btn-modal-cancel" onclick="document.getElementById('modalBatalkan').classList.remove('open')">Batal</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function showConfirmModal(type, id, siswa, tanggal, waktu) {
    var routes = {
        setuju:   '/guru/jadwal-konseling/' + id + '/setuju',
        tolak:    '/guru/jadwal-konseling/' + id + '/tolak',
        batalkan: '/guru/jadwal-konseling/' + id + '/batalkan',
    };
    if (type === 'setuju') {
        document.getElementById('setujuSiswa').textContent   = siswa;
        document.getElementById('setujuTanggal').textContent = tanggal;
        document.getElementById('setujuWaktu').textContent   = waktu;
        document.getElementById('formSetuju').action         = routes.setuju;
        document.getElementById('modalSetuju').classList.add('open');
    } else if (type === 'tolak') {
        document.getElementById('tolakSiswa').textContent    = siswa;
        document.getElementById('tolakTanggal').textContent  = tanggal;
        document.getElementById('formTolak').action          = routes.tolak;
        document.getElementById('modalTolak').classList.add('open');
    } else if (type === 'batalkan') {
        document.getElementById('batalkanSiswa').textContent   = siswa;
        document.getElementById('batalkanTanggal').textContent = tanggal;
        document.getElementById('batalkanWaktu').textContent   = waktu;
        document.getElementById('formBatalkan').action         = routes.batalkan;
        document.getElementById('modalBatalkan').classList.add('open');
    }
}
</script>
@endpush
