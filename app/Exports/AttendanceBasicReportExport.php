<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AttendanceBasicReportExport implements FromArray, WithHeadings, WithStyles
{
    protected $reportData;
    protected $dates;
    protected $companyName;
    protected $reportDate;

    public function __construct(array $reportData, array $dates, string $companyName)
    {
        $this->reportData = $reportData;
        $this->dates = $dates;
        $this->companyName = $companyName;
        $this->reportDate = now()->format('d M, Y'); // e.g., "07 Nov, 2024"
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->reportData as $employeeReport) {
            $presentCount = 0;
            $absentCount = 0;

            $employeeRow = [$employeeReport['employee_name']];

            foreach ($this->dates as $date) {
                $status = $employeeReport[$date]['status'] ?? 'A';
                $employeeRow[] = $status;

                if ($status === 'P') {
                    $presentCount++;
                } else {
                    $absentCount++;
                }
            }

            $employeeRow[] = $absentCount;
            $employeeRow[] = $presentCount;

            $data[] = $employeeRow;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            [$this->companyName],                      // Company name in the first row
            ["Report Date: " . $this->reportDate],     // Report date in the second row
            [],                                        // Empty row for spacing
            array_merge(['Employee Name'], $this->dates, ['Absent', 'Present']) // Main headings
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the company name and report date
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');

        // Merge cells for the company name and report date
        $lastColumn = $sheet->getHighestColumn();
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->mergeCells("A2:{$lastColumn}2");

        // Apply bold style to the main headers
        $sheet->getStyle('A4:' . $sheet->getHighestColumn() . '4')->getFont()->setBold(true);

        // Apply borders to the data range
        $totalRows = count($this->reportData) + 4; // +4 to account for the headers and company rows
        $sheet->getStyle("A4:{$lastColumn}{$totalRows}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [];
    }
}
