@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Report Perkembangan Mingguan - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Report Perkembangan Mingguan')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

@push('styles')
<style>
    .report-container {
        max-width: 900px;
    }

    /* Week Selector */
    .week-selector {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .week-selector__label {
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
    }
    .week-selector__dropdown {
        padding: 10px 16px;
        border: 1px solid #3E272330;
        border-radius: 6px;
        font-size: 14px;
        color: #3E2723;
        background: #fff;
        min-width: 200px;
        cursor: pointer;
    }
    .week-selector__dropdown:focus {
        outline: none;
        border-color: #4CAF82;
        box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
    }
    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #3E2723;
        color: #fff;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-download:hover {
        background: #3E2723;
    }
    .btn-download svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Report Card */
    .report-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        overflow: hidden;
    }
    .report-card__header {
        background: linear-gradient(135deg, #3E2723 0%, #3E2723 100%);
        color: #fff;
        padding: 20px 24px;
    }
    .report-card__title {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px;
    }
    .report-card__info {
        font-size: 13px;
        opacity: 0.9;
        line-height: 1.6;
    }
    .report-card__info p {
        margin: 0;
    }
    .report-card__body {
        padding: 24px;
    }

    /* Aspect Section */
    .aspect-section {
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #3E272310;
    }
    .aspect-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .aspect-section__title {
        font-size: 14px;
        font-weight: 700;
        color: #3E2723;
        margin-bottom: 12px;
        text-transform: uppercase;
    }

    /* Rating Display */
    .rating-display {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 12px;
    }
    .rating-box {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        border: 2px solid #3E272330;
        border-radius: 4px;
        color: #5D4037;
        background: #fff;
    }
    .rating-box.active {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        border-color: #4CAF82;
        color: #3E2723;
    }

    /* Notes Section */
    .aspect-notes {
        background: #f8f9fa;
        border: 1px solid #3E272310;
        border-radius: 6px;
        padding: 12px 16px;
    }
    .aspect-notes__label {
        font-size: 12px;
        font-weight: 600;
        color: #5D4037;
        margin-bottom: 4px;
    }
    .aspect-notes__text {
        font-size: 14px;
        color: #3E2723;
        line-height: 1.6;
    }

    /* General Notes */
    .general-notes {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        padding: 20px;
        margin-top: 24px;
    }
    .general-notes__title {
        font-size: 14px;
        font-weight: 700;
        color: #2E8B60;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .general-notes__text {
        font-size: 14px;
        color: #1E3A8A;
        line-height: 1.7;
    }

    /* Navigation */
    .report-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
    }
    .btn-nav {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #3E272330;
        border-radius: 6px;
        background: #fff;
        color: #3E2723;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-nav:hover {
        border-color: #4CAF82;
        background: #4CAF8210;
    }
    .btn-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .btn-nav svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
</style>
@endpush

<div class="report-container">
    {{-- Week Selector --}}
    <div class="week-selector">
        <span class="week-selector__label">PILIH MINGGU:</span>
        <select class="week-selector__dropdown" id="weekSelector">
            <option value="12" selected>Minggu 12 (18-22 Nov 20)</option>
            <option value="11">Minggu 11 (11-15 Nov 20)</option>
            <option value="10">Minggu 10 (04-08 Nov 20)</option>
            <option value="9">Minggu 9 (28 Okt - 01 Nov 20)</option>
            <option value="8">Minggu 8 (21-25 Okt 20)</option>
        </select>
        <button class="btn-download" onclick="downloadPDF()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            DOWNLOAD PDF
        </button>
    </div>

    {{-- Report Card --}}
    <div class="report-card">
        <div class="report-card__header">
            <h2 class="report-card__title">REPORT PERKEMBANGAN - MINGGU 12</h2>
            <div class="report-card__info">
                <p>Nama: {{ $student->nama ?? 'Ahmad Fauzi' }}</p>
                <p>Kelas: {{ $student->kelas ?? 'TK A' }}</p>
                <p>Periode: 18 - 22 November 2024</p>
            </div>
        </div>

        <div class="report-card__body">
            {{-- 1. Fisik-Motorik --}}
            <div class="aspect-section">
                <h3 class="aspect-section__title">1. FISIK-MOTORIK</h3>
                <div class="rating-display">
                    <div class="rating-box">BB</div>
                    <div class="rating-box">MB</div>
                    <div class="rating-box">BSH</div>
                    <div class="rating-box active">BSB</div>
                </div>
                <div class="aspect-notes">
                    <div class="aspect-notes__label">Catatan Guru:</div>
                    <div class="aspect-notes__text">
                        {{ $fisikMotorik->catatan ?? 'Perkembangan motorik kasar baik. Ahmad dapat melompat dan berlari dengan koordinasi yang baik. Motorik halus juga berkembang, dapat memegang pensil dengan benar.' }}
                    </div>
                </div>
            </div>

            {{-- 2. Kognitif --}}
            <div class="aspect-section">
                <h3 class="aspect-section__title">2. KOGNITIF</h3>
                <div class="rating-display">
                    <div class="rating-box">BB</div>
                    <div class="rating-box">MB</div>
                    <div class="rating-box">BSH</div>
                    <div class="rating-box active">BSB</div>
                </div>
                <div class="aspect-notes">
                    <div class="aspect-notes__label">Catatan Guru:</div>
                    <div class="aspect-notes__text">
                        {{ $kognitif->catatan ?? 'Sangat aktif dalam kegiatan berhitung. Mampu mengenai angka 1-20 dan dapat berhitung sederhana. Daya ingat sangat baik.' }}
                    </div>
                </div>
            </div>

            {{-- 3. Bahasa --}}
            <div class="aspect-section">
                <h3 class="aspect-section__title">3. BAHASA</h3>
                <div class="rating-display">
                    <div class="rating-box">BB</div>
                    <div class="rating-box">MB</div>
                    <div class="rating-box">BSH</div>
                    <div class="rating-box active">BSB</div>
                </div>
                <div class="aspect-notes">
                    <div class="aspect-notes__label">Catatan Guru:</div>
                    <div class="aspect-notes__text">
                        {{ $bahasa->catatan ?? 'Komunikasi verbal berkembang baik. Dapat menyampaikan keinginan dengan jelas. Perbendaharaan kata terus bertambah.' }}
                    </div>
                </div>
            </div>

            {{-- 4. Sosial-Emosional --}}
            <div class="aspect-section">
                <h3 class="aspect-section__title">4. SOSIAL-EMOSIONAL</h3>
                <div class="rating-display">
                    <div class="rating-box">BB</div>
                    <div class="rating-box">MB</div>
                    <div class="rating-box active">BSH</div>
                    <div class="rating-box">BSB</div>
                </div>
                <div class="aspect-notes">
                    <div class="aspect-notes__label">Catatan Guru:</div>
                    <div class="aspect-notes__text">
                        {{ $sosialEmosional->catatan ?? 'Masih perlu bimbingan dalam hal berbagi dengan teman. Kadang masih ingin menang sendiri saat bermain. Perlu dilatih empati.' }}
                    </div>
                </div>
            </div>

            {{-- 5. Nilai Agama & Moral --}}
            <div class="aspect-section">
                <h3 class="aspect-section__title">5. NILAI AGAMA & MORAL</h3>
                <div class="rating-display">
                    <div class="rating-box">BB</div>
                    <div class="rating-box">MB</div>
                    <div class="rating-box">BSH</div>
                    <div class="rating-box active">BSB</div>
                </div>
                <div class="aspect-notes">
                    <div class="aspect-notes__label">Catatan Guru:</div>
                    <div class="aspect-notes__text">
                        {{ $nilaiAgama->catatan ?? 'Hafalan doa sudah lancar. Rajin mengikuti kegiatan keagamaan. Sudah terbiasa mengucap salam dan berdoa sebelum makan.' }}
                    </div>
                </div>
            </div>

            {{-- 6. Seni --}}
            <div class="aspect-section">
                <h3 class="aspect-section__title">6. SENI</h3>
                <div class="rating-display">
                    <div class="rating-box">BB</div>
                    <div class="rating-box">MB</div>
                    <div class="rating-box">BSH</div>
                    <div class="rating-box active">BSB</div>
                </div>
                <div class="aspect-notes">
                    <div class="aspect-notes__label">Catatan Guru:</div>
                    <div class="aspect-notes__text">
                        {{ $seni->catatan ?? 'Kreatif dalam menggambar dan mewarnai. Senang mengikuti kegiatan menyanyi. Memiliki imajinasi yang baik.' }}
                    </div>
                </div>
            </div>

            {{-- General Notes --}}
            <div class="general-notes">
                <h4 class="general-notes__title">CATATAN UMUM GURU:</h4>
                <p class="general-notes__text">
                    {{ $catatanUmum ?? 'Secara keseluruhan, perkembangan Ahmad minggu ini sangat baik. Perlu perhatian khusus pada aspek sosial-emosional terutama dalam hal berbagi dengan teman. Disarankan untuk melatih Ahmad berbagi mainan di rumah dan mengajarkan pentingnya bekerja sama dengan orang lain.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <div class="report-nav">
        <button class="btn-nav" id="prevWeek">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z" clip-rule="evenodd"/></svg>
            Minggu Sebelumnya
        </button>
        <button class="btn-nav" id="nextWeek" disabled>
            Minggu Berikutnya
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/></svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function downloadPDF() {
        // Logic to download PDF
        alert('Fitur download PDF akan segera tersedia');
    }

    document.getElementById('weekSelector').addEventListener('change', function() {
        // Logic to load different week's report
        const week = this.value;
        // window.location.href = `/orangtua/report-mingguan?week=${week}`;
    });
</script>
@endpush

@endsection
