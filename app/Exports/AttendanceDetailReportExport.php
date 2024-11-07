<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AttendanceDetailReportExport implements FromArray, WithHeadings, WithStyles
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

            $rowCheckIn = ['Employee Name' => $employeeReport['employee_name'], 'Type' => 'Check In'];
            $rowCheckOut = ['Employee Name' => '', 'Type' => 'Check Out'];
            $rowStatus = ['Employee Name' => '', 'Type' => 'Status'];

            foreach ($this->dates as $date) {
                $status = $employeeReport[$date]['status'] ?? 'A';
                $rowCheckIn[$date] = $employeeReport[$date]['check_in'] ?? '';
                $rowCheckOut[$date] = $employeeReport[$date]['check_out'] ?? '';
                $rowStatus[$date] = $status;

                if ($status === 'P') {
                    $presentCount++;
                } else {
                    $absentCount++;
                }
            }

            $rowCheckIn['Total Present'] = '';
            $rowCheckOut['Total Present'] = '';
            $rowStatus['Total Present'] = $presentCount;

            $rowCheckIn['Total Absent'] = '';
            $rowCheckOut['Total Absent'] = '';
            $rowStatus['Total Absent'] = $absentCount;

            $data[] = $rowCheckIn;
            $data[] = $rowCheckOut;
            $data[] = $rowStatus;
            $data[] = []; // Blank row between employees
        }

        return $data;
    }

    public function headings(): array
    {
        $headings = ['Employee Name', 'Type'];

        foreach ($this->dates as $date) {
            $headings[] = $date;
        }

        $headings[] = 'Total Present';
        $headings[] = 'Total Absent';

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold style to the header row
        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);

        // Determine the range of data for applying borders
        $totalRows = count($this->reportData) * 4; // 3 rows per employee + 1 blank row
        $lastColumn = $sheet->getHighestColumn();

        // Apply border style to the data range
        $sheet->getStyle("A1:{$lastColumn}{$totalRows}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Set bold for the first column and the "Type" column for each row
        $sheet->getStyle("A1:A{$totalRows}")->getFont()->setBold(true);

        return [];
    }
}
