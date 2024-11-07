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
    protected $companyName;
    protected $reportDate;

    public function __construct(array $reportData, array $dates, string $companyName)
    {
        $this->reportData = $reportData;
        $this->dates = $dates;
        $this->companyName = $companyName;
        $this->reportDate = now()->format('d M, Y'); // Format as "07 Nov, 2024"
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
            $data[] = [];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            [$this->companyName],
            ["Report Date: " . $this->reportDate],
            [],
            array_merge(['Employee Name', 'Type'], $this->dates, ['Total Present', 'Total Absent']),
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A4:' . $sheet->getHighestColumn() . '4')->getFont()->setBold(true);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');

        $lastColumn = $sheet->getHighestColumn();
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->mergeCells("A2:{$lastColumn}2");

        $totalRows = count($this->reportData) * 4;
        $sheet->getStyle("A4:{$lastColumn}{$totalRows}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [];
    }
}
