<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TodayAttendanceReportExport implements FromArray, WithHeadings, WithEvents
{
    protected $reportData;
    protected $companyName;
    protected $reportDate;

    public function __construct(array $reportData, string $companyName)
    {
        $this->reportData = $reportData;
        $this->companyName = $companyName;
        $this->reportDate = now()->format('d M, Y'); // e.g., "07 Nov, 2024"
    }

    public function array(): array
    {
        return $this->reportData;
    }

    public function headings(): array
    {
        return [
            [$this->companyName],             // Company name on the first row
            ["Date: " . $this->reportDate],   // Report date on the second row
            [],                               // Empty row for spacing
            ['SR', 'Employee Name', 'Check-in', 'Check-out', 'Status'], // Column headers
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cells for the company name and date rows to center-align
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->mergeCells('A2:E2');
                
                // Set font styles for the company name and date rows
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A2')->getFont()->setItalic(true);

                // Center-align the company name and date rows
                $event->sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
