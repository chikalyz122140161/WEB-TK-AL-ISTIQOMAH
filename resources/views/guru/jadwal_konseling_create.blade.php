@extends('layouts.app')

@section('title', ($mode === 'kelas' ? 'Buat Jadwal Per Kelas' : 'Buat Jadwal Per Siswa') . ' - SISTEM TK AL-ISTIQOMAH')
@section('page_title', $mode === 'kelas' ? 'Buat Jadwal Per Kelas' : 'Buat Jadwal Per Siswa')

@push('styles')
    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #5D4037;
            margin-bottom: 14px;
            transition: color .15s;
            text-decoration: none;
        }

        .back-link:hover {
            color: #3D9B72;
        }

        .back-link svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #4CAF82;
        }

        .section-header__icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-header__icon svg {
            width: 22px;
            height: 22px;
            fill: #fff;
        }

        .section-header__text h2 {
            font-size: 17px;
            font-weight: 700;
            color: #3E2723;
            margin: 0;
        }

        .section-header__text p {
            font-size: 12px;
            color: #5D4037;
            margin: 2px 0 0;
        }

        .info-alert {
            background: #fcf8b3;
            border: 1px solid #FFF176;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            color: #3E2723;
            line-height: 1.55;
        }

        .info-alert svg {
            width: 18px;
            height: 18px;
            fill: #3E2723;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .form-card {
            background: #fff;
            border: 1px solid #3E272320;
            border-radius: 10px;
            padding: 22px 24px;
            margin-bottom: 18px;
        }

        .form-card__title {
            font-size: 15px;
            font-weight: 600;
            color: #3E2723;
            margin: 0 0 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #3E272310;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group--full {
            grid-column: 1 / -1;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #3E2723;
        }

        .form-group label span.req {
            color: #F06292;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px 14px;
            border: 1px solid #3E272320;
            border-radius: 7px;
            font-size: 13px;
            color: #3E2723;
            background: #f8f9fa;
            font-family: inherit;
            transition: all .15s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4CAF82;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-hint {
            font-size: 11px;
            color: #5D4037;
            margin-top: 3px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #3E272310;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            color: #fff;
            padding: 11px 22px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all .15s;
            font-family: inherit;
            box-shadow: 0 2px 6px rgba(61, 155, 114, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 175, 130, 0.4);
        }

        .btn-submit svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            background: #f3f4f6;
            color: #374151;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: background .15s;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }
    </style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <a href="{{ route('guru.jadwal_konseling') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z"
                clip-rule="evenodd" />
        </svg>
        Kembali ke Jadwal Konseling
    </a>

    <div class="section-header">
        <div class="section-header__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div class="section-header__text">
            <h2>{{ $mode === 'kelas' ? 'Buat Jadwal Konseling Per Kelas' : 'Buat Jadwal Konseling Per Siswa' }}</h2>
            <p>
                @if ($mode === 'kelas')
                    Jadwal akan dibuat sekaligus untuk seluruh siswa di class term terpilih.
                @else
                    Buat jadwal konseling untuk satu siswa secara langsung.
                @endif
            </p>
        </div>
    </div>

    <div class="info-alert">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                clip-rule="evenodd" />
        </svg>
        <div>
            Konseling dapat dijadwalkan pada hari kerja (Senin – Jumat) pukul 08:00 – 15:00.
            @if ($mode === 'kelas')
                <br>
                <strong>Mode Per Kelas:</strong> satu form ini akan men-generate jadwal terpisah untuk setiap siswa di class
                term yang dipilih.
            @endif
        </div>
    </div>

    <form action="{{ route('guru.store_jadwal_konseling') }}" method="POST" class="form-card">
        @csrf
        <h3 class="form-card__title">Form Buat Jadwal Konseling</h3>

        <input type="hidden" name="mode" value="{{ $mode }}">

        <div class="form-grid">
            {{-- Class Term (selalu ada) --}}
            <div class="form-group {{ $mode === 'kelas' ? 'form-group--full' : '' }}">
                <label>Class Term (Tahun Ajaran + Kelas) <span class="req">*</span></label>
                <select name="class_term_id" id="selClassTerm" required onchange="updateSiswa()">
                    <option value="" disabled selected>-- Pilih Class Term --</option>
                    @foreach ($classTerms as $ct)
                        <option value="{{ $ct['id'] }}">
                            {{ $ct['label'] }} ({{ $ct['siswa_count'] }} siswa)
                        </option>
                    @endforeach
                </select>
                @if ($mode === 'kelas')
                    <div class="form-hint">
                        Jadwal akan dibuat untuk <strong id="kelasCount">0</strong> siswa di class term ini.
                    </div>
                @endif
            </div>

            {{-- Siswa: hanya muncul di mode 'siswa' --}}
            @if ($mode === 'siswa')
                <div class="form-group">
                    <label>Siswa <span class="req">*</span></label>
                    <select name="siswa_id" id="selSiswa" required>
                        <option value="" disabled selected>-- Pilih Class Term dulu --</option>
                    </select>
                </div>
            @endif

            <div class="form-group">
                <label>Tanggal <span class="req">*</span></label>
                <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label>Jam Mulai <span class="req">*</span></label>
                <input type="time" name="waktu_mulai" required>
            </div>

            <div class="form-group">
                <label>Jam Selesai <span class="req">*</span></label>
                <input type="time" name="waktu_selesai" required>
            </div>

            <div class="form-group form-group--full">
                <label>Topik / Permasalahan <span class="req">*</span></label>
                <textarea name="topik" placeholder="Jelaskan topik atau materi konseling..." required></textarea>
                <div class="form-hint">Deskripsikan agar orang tua tahu materi yang akan dibahas.</div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('guru.jadwal_konseling') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                        clip-rule="evenodd" />
                </svg>
                Simpan Jadwal
            </button>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        var CLASS_TERMS = {!! json_encode($classTerms, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
        var MODE = @json($mode);

        function updateSiswa() {
            var ctId = document.getElementById('selClassTerm').value;
            var ct = CLASS_TERMS.find(function(c) {
                return c.id === ctId;
            });

            if (MODE === 'siswa') {
                var sel = document.getElementById('selSiswa');
                if (!ct || ct.siswa.length === 0) {
                    sel.innerHTML = '<option value="" disabled selected>Tidak ada siswa</option>';
                } else {
                    var opts = ct.siswa.map(function(s) {
                        return '<option value="' + s.id + '">' + s.nama + '</option>';
                    }).join('');
                    sel.innerHTML = '<option value="" disabled selected>-- Pilih Siswa --</option>' + opts;
                }
            }

            if (MODE === 'kelas') {
                var el = document.getElementById('kelasCount');
                if (el) el.textContent = ct ? ct.siswa_count : 0;
            }
        }
    </script>
@endpush
