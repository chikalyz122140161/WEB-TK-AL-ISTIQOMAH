@extends('layouts.app')

@section('title', 'Edit Jadwal Konseling - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Edit Jadwal Konseling')

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

    .form-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 12px;
        overflow: hidden;
        max-width: 680px;
    }
    .form-card__header {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff;
        padding: 22px 28px;
    }
    .form-card__header h2 { margin: 0; font-size: 17px; font-weight: 700; }
    .form-card__body { padding: 28px; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .form-group { margin-bottom: 18px; }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #3E2723;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 6px;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        height: 40px;
        border: 1px solid #3E272330;
        border-radius: 8px;
        padding: 0 12px;
        font-size: 14px;
        color: #3E2723;
        box-sizing: border-box;
        background: #fff;
        transition: border-color .15s;
        outline: none;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { border-color: #3D9B72; box-shadow: 0 0 0 3px rgba(76,175,130,0.1); }
    .form-group textarea { height: 90px; padding: 10px 12px; resize: vertical; }
    .form-group select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236B7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z' clip-rule='evenodd'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 16px; padding-right: 34px; }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }
    .btn-save {
        height: 40px;
        padding: 0 24px;
        background: linear-gradient(135deg, #3D9B72, #2E8B60);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: opacity .15s;
    }
    .btn-save:hover { opacity: .9; }
    .btn-cancel {
        height: 40px;
        padding: 0 20px;
        background: #fff;
        color: #3E2723;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #3E272330;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-cancel:hover { background: #FFFDE7; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <a href="{{ route('guru.jadwal_konseling.show', $jadwal['id']) }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
        Kembali ke Detail Jadwal
    </a>

    <div class="form-card">
        <div class="form-card__header">
            <h2>Edit Jadwal Konseling</h2>
        </div>
        <div class="form-card__body">
            <form method="POST" action="{{ route('guru.jadwal_konseling.update', $jadwal['id']) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Orang Tua</label>
                        <select name="orang_tua">
                            @foreach ($daftarOrangTua as $ot)
                                <option value="{{ $ot['nama'] }}" @selected($ot['nama'] === $jadwal['orang_tua'])>{{ $ot['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Siswa</label>
                        <select name="siswa">
                            @foreach ($daftarSiswa as $s)
                                <option value="{{ $s['nama'] }}" @selected($s['nama'] === $jadwal['siswa'])>{{ $s['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Topik Konseling</label>
                    <input type="text" name="topik" value="{{ $jadwal['topik'] }}" placeholder="Masukkan topik konseling">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $jadwal['tanggal_raw'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        {{-- waktu split from "HH:MM - HH:MM" --}}
                        @php
                            $waktuParts = explode(' - ', $jadwal['waktu']);
                            $waktuMulai  = $waktuParts[0] ?? '';
                            $waktuSelesai = $waktuParts[1] ?? '';
                        @endphp
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="waktu_mulai" value="{{ $waktuMulai }}">
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="waktu_selesai" value="{{ $waktuSelesai }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" placeholder="Catatan tambahan (opsional)">{{ $jadwal['catatan'] }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                    <a href="{{ route('guru.jadwal_konseling.show', $jadwal['id']) }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>

@endsection
