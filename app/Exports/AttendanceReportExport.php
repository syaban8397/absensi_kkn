<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function __construct(private readonly Collection $rows)
    {
    }

    public function collection(): Collection
    {
        return $this->rows->map(fn (array $row) => [
            $row['nama'],
            $row['status_kehadiran_hari'],
            $row['hadir'],
            $row['izin'],
            $row['pulang'],
            $row['alfa'],
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Status Kehadiran Hari',
            'Hadir',
            'Izin',
            'Pulang',
            'Alfa',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
