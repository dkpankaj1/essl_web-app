<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
class TodayAttendanceReportExport implements FromArray, WithHeadings, WithEvents
{
    protected $reportData;
    protected $companyName;
    protected $reportDate;

    public function __construct(array $reportData, string $companyName)
    {
        $this->reportData = $reportData;
        $this->companyName = $companyName;
        $this->reportDate = now()->format('d M, Y');
    }

    public function array(): array
    {
        return $this->reportData;
    }

    public function headings(): array
    {
        return [
            [$this->companyName],
            ["Date: " . $this->reportDate],
            [],
            ['SR', 'Employee Name', 'Check-in', 'Check-out', 'Status'],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->mergeCells('A2:E2');
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A2')->getFont()->setItalic(true);

                $event->sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
                $lastRow = count($this->reportData) + 4;
    
                $event->sheet->getStyle("A4:E{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}
