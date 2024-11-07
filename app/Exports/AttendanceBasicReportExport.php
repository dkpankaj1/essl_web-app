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

    public function __construct(array $reportData, array $dates)
    {
        $this->reportData = $reportData;
        $this->dates = $dates;
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->reportData as $employeeReport) {
            $presentCount = 0;
            $absentCount = 0;

            // Start the row with the employee's name
            $employeeRow = [$employeeReport['employee_name']];

            // Add the attendance status for each day
            foreach ($this->dates as $date) {
                $status = $employeeReport[$date]['status'] ?? 'A';  // 'A' for absent by default
                $employeeRow[] = $status;

                // Increment the present/absent counters
                if ($status === 'P') {
                    $presentCount++;
                } else {
                    $absentCount++;
                }
            }

            // Add the present and absent counts at the end of the row
            $employeeRow[] = $absentCount;
            $employeeRow[] = $presentCount;

            // Add the row to the data array
            $data[] = $employeeRow;
        }

        return $data;
    }

    public function headings(): array
    {
        // Start the headings with "Employee Name"
        $headings = ['Employee Name'];

        // Add the date columns
        foreach ($this->dates as $date) {
            $headings[] = $date;
        }

        // Add the "Absent" and "Present" columns
        $headings[] = 'Absent';
        $headings[] = 'Present';

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold style to the "Employee Name" column (A)
        $sheet->getStyle('A1:A' . $sheet->getHighestRow())->getFont()->setBold(true);

        // Apply border style to the entire data range
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [];
    }
}
