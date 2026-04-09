@extends('layouts.app')

@section('title', 'Detail Jadwal Konseling - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Jadwal Konseling')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #5D4037;
        margin-bottom: 20px;
        transition: color 0.2s;
        text-decoration: none;
    }
    .back-link:hover { color: #3E2723; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }

    .detail-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 12px;
        overflow: hidden;
        max-width: 700px;
    }
    .detail-card__header {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff;
        padding: 24px 28px;
    }
    .detail-card__title {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 10px;
    }
    .detail-card__meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 20px;
        font-size: 13px;
        opacity: .9;
    }
    .detail-card__meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .detail-card__meta svg { width: 14px; height: 14px; fill: currentColor; }

    .detail-card__body { padding: 28px; }

    .info-row {
        display: grid;
        grid-template-columns: 160px 1fr;
        gap: 8px 16px;
        font-size: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #FFFDE7;
        align-items: start;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row__label {
        font-size: 12px;
        font-weight: 700;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .info-row__value { color: #3E2723; font-weight: 500; }

    .badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .3px;
        text-transform: uppercase;
    }
    .badge--disetujui { background: #ffedd5; color: #c2410c; }
    .badge--pending   { background: #FFFDE7; color: #5D4037; border: 1px solid #3E272330; }
    .badge--selesai   { background: #3E2723; color: #FFFDE7; }
    .badge--tolak     { background: #FEE2E2; color: #B91C1C; }

    .detail-actions {
        display: flex;
        gap: 10px;
        margin-top: 24px;
        flex-wrap: wrap;
    }
    .btn-edit {
        height: 38px;
        padding: 0 20px;
        background: #FFFBEB;
        color: #5D4037;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #FFF176;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background .15s;
    }
    .btn-edit:hover { background: #FFF176; }
    .btn-setuju {
        height: 38px;
        padding: 0 20px;
        background: #ffedd5;
        color: #c2410c;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #fed7aa;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-setuju:hover { background: #fed7aa; }
    .btn-tolak, .btn-batalkan {
        height: 38px;
        padding: 0 20px;
        background: #FEF2F2;
        color: #B91C1C;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #FECACA;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-tolak:hover, .btn-batalkan:hover { background: #FEE2E2; }

    /* Modal */
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
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal__icon { font-size: 40px; text-align: center; margin-bottom: 12px; }
    .modal__title {
        font-size: 16px;
        font-weight: 700;
        color: #3E2723;
        margin: 0 0 8px;
        text-align: center;
    }
    .modal__desc {
        font-size: 13px;
        color: #5D4037;
        text-align: center;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .modal-actions { display: flex; gap: 10px; }
    .btn-modal-confirm {
        flex: 1;
        height: 38px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-confirm.green { background: #ffedd5; color: #c2410c; }
    .btn-modal-confirm.green:hover { background: #fed7aa; }
    .btn-modal-confirm.red { background: #FEE2E2; color: #B91C1C; }
    .btn-modal-confirm.red:hover { background: #FECACA; }
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
    }
    .btn-modal-cancel:hover { background: #FFFDE7; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <a href="{{ route('guru.jadwal_konseling') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
        Kembali ke Jadwal Konseling
    </a>

    <div class="detail-card">
        <div class="detail-card__header">
            <div class="detail-card__title">Detail Jadwal Konseling</div>
            <div class="detail-card__meta">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    {{ $jadwal['tanggal'] }}
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                    {{ $jadwal['waktu'] }}
                </span>
            </div>
        </div>

        <div class="detail-card__body">
            <div class="info-row">
                <div class="info-row__label">Orang Tua</div>
                <div class="info-row__value">{{ $jadwal['orang_tua'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-row__label">Siswa</div>
                <div class="info-row__value">{{ $jadwal['siswa'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-row__label">Topik</div>
                <div class="info-row__value">{{ $jadwal['topik'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-row__label">Status</div>
                <div class="info-row__value">
                    @if ($jadwal['status'] === 'disetujui')
                        <span class="badge badge--disetujui">Disetujui</span>
                    @elseif ($jadwal['status'] === 'pending')
                        <span class="badge badge--pending">Pending</span>
                    @elseif ($jadwal['status'] === 'selesai')
                        <span class="badge badge--selesai">Selesai</span>
                    @else
                        <span class="badge badge--tolak">Ditolak</span>
                    @endif
                </div>
            </div>
            @if ($jadwal['catatan'])
            <div class="info-row">
                <div class="info-row__label">Catatan</div>
                <div class="info-row__value">{{ $jadwal['catatan'] }}</div>
            </div>
            @endif

            <div class="detail-actions">
                <a href="{{ route('guru.jadwal_konseling.edit', $jadwal['id']) }}" class="btn-edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;"><path d="M5.433 13.917l1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z"/><path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z"/></svg>
                    Edit
                </a>
                @if ($jadwal['status'] === 'pending')
                    <button class="btn-setuju" onclick="document.getElementById('modalSetuju').classList.add('open')">Setujui</button>
                    <button class="btn-tolak" onclick="document.getElementById('modalTolak').classList.add('open')">Tolak</button>
                @elseif ($jadwal['status'] === 'disetujui')
                    <button class="btn-batalkan" onclick="document.getElementById('modalBatalkan').classList.add('open')">Batalkan</button>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Setujui --}}
    <div class="modal-overlay" id="modalSetuju" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <div class="modal__icon">✅</div>
            <div class="modal__title">Setujui Jadwal Konseling?</div>
            <div class="modal__desc">Jadwal konseling <strong>{{ $jadwal['siswa'] }}</strong> pada <strong>{{ $jadwal['tanggal'] }}</strong> pukul <strong>{{ $jadwal['waktu'] }}</strong> akan disetujui.</div>
            <div class="modal-actions">
                <form method="POST" action="{{ route('guru.jadwal_konseling.setuju', $jadwal['id']) }}" style="flex:1">
                    @csrf
                    <button type="submit" class="btn-modal-confirm green" style="width:100%;">Ya, Setujui</button>
                </form>
                <button class="btn-modal-cancel" onclick="document.getElementById('modalSetuju').classList.remove('open')">Batal</button>
            </div>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div class="modal-overlay" id="modalTolak" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <div class="modal__icon">❌</div>
            <div class="modal__title">Tolak Jadwal Konseling?</div>
            <div class="modal__desc">Jadwal konseling <strong>{{ $jadwal['siswa'] }}</strong> pada <strong>{{ $jadwal['tanggal'] }}</strong> akan ditolak. Tindakan ini tidak bisa dibatalkan.</div>
            <div class="modal-actions">
                <form method="POST" action="{{ route('guru.jadwal_konseling.tolak', $jadwal['id']) }}" style="flex:1">
                    @csrf
                    <button type="submit" class="btn-modal-confirm red" style="width:100%;">Ya, Tolak</button>
                </form>
                <button class="btn-modal-cancel" onclick="document.getElementById('modalTolak').classList.remove('open')">Batal</button>
            </div>
        </div>
    </div>

    {{-- Modal Batalkan --}}
    <div class="modal-overlay" id="modalBatalkan" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <div class="modal__icon">⚠️</div>
            <div class="modal__title">Batalkan Jadwal Konseling?</div>
            <div class="modal__desc">Jadwal konseling <strong>{{ $jadwal['siswa'] }}</strong> pada <strong>{{ $jadwal['tanggal'] }}</strong> pukul <strong>{{ $jadwal['waktu'] }}</strong> akan dibatalkan.</div>
            <div class="modal-actions">
                <form method="POST" action="{{ route('guru.jadwal_konseling.batalkan', $jadwal['id']) }}" style="flex:1">
                    @csrf
                    <button type="submit" class="btn-modal-confirm red" style="width:100%;">Ya, Batalkan</button>
                </form>
                <button class="btn-modal-cancel" onclick="document.getElementById('modalBatalkan').classList.remove('open')">Batal</button>
            </div>
        </div>
    </div>

@endsection
