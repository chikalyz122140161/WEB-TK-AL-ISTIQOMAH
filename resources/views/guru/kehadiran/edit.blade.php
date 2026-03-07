@extends('layouts.app')

@section('title', 'Edit Kehadiran - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Edit Kehadiran')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    .form-section {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .form-section__title {
        font-size: 16px;
        font-weight: 600;
        color: #00473e;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #faae2b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section__title svg {
        width: 20px;
        height: 20px;
        fill: #faae2b;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 500;
        color: #475d5b;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px 12px;
        border: 1px solid #00473e20;
        border-radius: 6px;
        font-size: 14px;
        color: #475d5b;
        background: #f2f7f5;
        transition: all 0.2s;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #faae2b;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.15);
    }
    .form-group input[readonly] {
        background: #e5e7eb;
        cursor: not-allowed;
    }
    .btn-orange {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(250, 174, 43, 0.3);
        transition: all 0.3s;
    }
    .btn-orange:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(250, 174, 43, 0.4);
    }
    .btn-orange svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #00473e20;
        color: #00473e;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #00473e30;
    }
    .btn-secondary svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #475d5b;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 16px;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #faae2b;
    }
    .back-link svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Student Info Card */
    .student-info-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: linear-gradient(135deg, #f2f7f5 0%, #e6f0ec 100%);
        border: 1px solid #00473e20;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .student-info-card__avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
    }
    .student-info-card__name {
        font-size: 16px;
        font-weight: 600;
        color: #00473e;
    }
    .student-info-card__detail {
        font-size: 13px;
        color: #475d5b;
        margin-top: 2px;
    }

    /* Status Selector */
    .status-selector {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .status-selector__option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: 2px solid #00473e20;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
        min-width: 100px;
        justify-content: center;
    }
    .status-selector__option:hover {
        border-color: #faae2b;
    }
    .status-selector__option.active {
        border-color: #faae2b;
        background: #faae2b15;
    }
    .status-selector__option input {
        display: none;
    }
    .status-selector__option--hadir.active {
        border-color: #047857;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
    }
    .status-selector__option--izin.active {
        border-color: #b45309;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    .status-selector__option--sakit.active {
        border-color: #1d4ed8;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }
    .status-selector__option--alpa.active {
        border-color: #dc2626;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }

    @media (max-width: 768px) {
        .status-selector {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
    <a href="{{ route('guru.kehadiran.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
        </svg>
        Kembali ke List Kehadiran
    </a>

    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/>
            </svg>
            Edit Kehadiran
        </div>

        <!-- Student Info -->
        <div class="student-info-card">
            <div class="student-info-card__avatar">{{ strtoupper(substr($kehadiran['nama'], 0, 1)) }}</div>
            <div>
                <div class="student-info-card__name">{{ $kehadiran['nama'] }}</div>
                <div class="student-info-card__detail">{{ $kehadiran['kelas'] }} &bull; Tanggal: {{ \Carbon\Carbon::parse($kehadiran['tanggal'])->format('d M Y') }}</div>
            </div>
        </div>

        <form action="{{ route('guru.kehadiran.update', $kehadiran['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 20px;">
                <label>Status Kehadiran</label>
                <div class="status-selector">
                    <label class="status-selector__option status-selector__option--hadir {{ $kehadiran['status'] == 'hadir' ? 'active' : '' }}">
                        <input type="radio" name="status" value="hadir" {{ $kehadiran['status'] == 'hadir' ? 'checked' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                        </svg>
                        Hadir
                    </label>
                    <label class="status-selector__option status-selector__option--izin {{ $kehadiran['status'] == 'izin' ? 'active' : '' }}">
                        <input type="radio" name="status" value="izin" {{ $kehadiran['status'] == 'izin' ? 'checked' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd"/>
                        </svg>
                        Izin
                    </label>
                    <label class="status-selector__option status-selector__option--sakit {{ $kehadiran['status'] == 'sakit' ? 'active' : '' }}">
                        <input type="radio" name="status" value="sakit" {{ $kehadiran['status'] == 'sakit' ? 'checked' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z"/>
                        </svg>
                        Sakit
                    </label>
                    <label class="status-selector__option status-selector__option--alpa {{ $kehadiran['status'] == 'alpa' ? 'active' : '' }}">
                        <input type="radio" name="status" value="alpa" {{ $kehadiran['status'] == 'alpa' ? 'checked' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd"/>
                        </svg>
                        Alpa
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label>Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Tambahkan keterangan (opsional)...">{{ $kehadiran['keterangan'] != '-' ? $kehadiran['keterangan'] : '' }}</textarea>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('guru.kehadiran.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.status-selector__option').forEach(function(option) {
        option.addEventListener('click', function() {
            document.querySelectorAll('.status-selector__option').forEach(function(opt) {
                opt.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>
@endpush
