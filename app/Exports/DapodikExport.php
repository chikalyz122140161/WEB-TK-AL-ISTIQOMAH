<?php

namespace App\Exports;

use App\Models\AcademicTerm;
use App\Models\StudentEnrollment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DapodikExport implements FromCollection, ShouldAutoSize, WithStyles, WithEvents
{
    private string $academicTermId;

    // Function ini menyiapkan data awal yang dibutuhkan oleh class.
    // Biasanya dipakai agar data bisa langsung tersedia saat email, service, atau export dijalankan.
    public function __construct(string $academicTermId)
    {
        $this->academicTermId = $academicTermId;
    }

    // Function ini menyiapkan kumpulan data yang akan diexport.
    // Data dari database disusun menjadi format yang siap masuk ke file Excel.
    public function collection()
    {
        // Header rows nanti diisi di registerEvents() — di sini hanya data per kelas
        $rows = collect();

        $kelasOrder = ['A', 'B1', 'B2'];
        $globalNo   = 0;

        foreach ($kelasOrder as $kelas) {
            $enrollments = StudentEnrollment::whereHas(
                'classTerm',
                fn($q) => $q->where('academic_term_id', $this->academicTermId)
                    ->whereHas('class', fn($qc) => $qc->where('name', $kelas))
            )
                ->with(['student.parents'])
                ->get();

            // Filter unique siswa berdasarkan name (jaga-jaga duplikat enrollment)
            $siswa = $enrollments->map->student->unique('id')->sortBy('name')->values();

            if ($siswa->isEmpty()) {
                continue;
            }

            // Sub-header "KELAS X"
            $rows->push(["KELAS {$kelas}", '', '', '', '', '', '', '', '', '', '', '', '', '']);

            $no = 1;
            foreach ($siswa as $s) {
                $ayah = $s->parents->firstWhere('category', 'ayah');
                $ibu  = $s->parents->firstWhere('category', 'ibu');

                $rows->push([
                    $no++,
                    strtoupper($s->name),
                    $s->gender === 'L' ? 'L' : 'P',
                    $kelas,
                    $s->nis ?? '',
                    $s->nisn ?? '',
                    $s->pob ?? $s->tempat_lahir ?? '',
                    $s->dob ? Carbon::parse($s->dob)->format('Y-m-d') : '',
                    $s->nik ?? '',
                    $s->address ?? '',
                    $s->phone ?? $s->telepon ?? '',
                    optional($ayah)->name ?? $s->nama_ayah ?? '',
                    optional($ayah)->work ?? $s->pekerjaan_ayah ?? '',
                    optional($ibu)->name ?? $s->nama_ibu ?? '',
                    optional($ibu)->work ?? $s->pekerjaan_ibu ?? '',
                ]);
                $globalNo++;
            }
            // Spacer kosong antar kelas
            $rows->push(array_fill(0, 15, ''));
        }

        return $rows;
    }

    // Function ini mengatur gaya tampilan file Excel.
    // Contohnya mengatur header, ukuran kolom, atau tampilan tabel agar lebih rapi.
    public function styles(Worksheet $sheet)
    {
        // Will be styled via AfterSheet event
        return [];
    }

    // Function ini mendaftarkan event tambahan saat proses export berjalan.
    // Biasanya dipakai untuk mengatur tampilan Excel setelah data selesai dibuat.
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $term       = AcademicTerm::find($this->academicTermId);
                $tahunAjar  = $term?->academic_year ?? '-';
                $semester   = ucfirst($term?->semester ?? '-');

                // Insert 5 rows di atas untuk header informasi & kolom
                $sheet->insertNewRowBefore(1, 5);

                $sheet->setCellValue('A1', 'DAFTAR PESERTA DIDIK TK AL-ISTIQOMAH');
                $sheet->setCellValue('A2', 'Kecamatan Kec. Labuhan Ratu, Kabupaten Kota Bandar Lampung, Provinsi Prov. Lampung');
                $sheet->setCellValue('A3', "Tahun Ajaran {$tahunAjar} — Semester {$semester}");

                $sheet->mergeCells('A1:O1');
                $sheet->mergeCells('A2:O2');
                $sheet->mergeCells('A3:O3');

                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('A2:A3')->applyFromArray([
                    'font'      => ['size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Kolom header di row 5
                $headers = [
                    'NO', 'NAMA', 'JK', 'ROMBEL', 'NOMOR INDUK', 'NISN',
                    'TEMPAT LAHIR', 'TANGGAL LAHIR', 'NIK', 'ALAMAT', 'HP',
                    'NAMA AYAH', 'PEKERJAAN AYAH', 'NAMA IBU', 'PEKERJAAN IBU',
                ];
                foreach ($headers as $i => $h) {
                    $col = chr(65 + $i); // A, B, C, ...
                    $sheet->setCellValue($col . '5', $h);
                }

                // Style header kolom
                $sheet->getStyle('A5:O5')->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '3D9B72'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                    ],
                ]);
                $sheet->getRowDimension(5)->setRowHeight(28);

                // Beri border ke seluruh data
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A5:O' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']],
                    ],
                ]);

                // Highlight sub-header "KELAS X"
                for ($r = 6; $r <= $highestRow; $r++) {
                    $cell = $sheet->getCell('A' . $r)->getValue();
                    if (is_string($cell) && str_starts_with($cell, 'KELAS ')) {
                        $sheet->mergeCells('A' . $r . ':O' . $r);
                        $sheet->getStyle('A' . $r)->applyFromArray([
                            'font'      => ['bold' => true, 'size' => 12],
                            'fill'      => [
                                'fillType'   => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FFFDE7'],
                            ],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                    }
                }
            },
        ];
    }
}
