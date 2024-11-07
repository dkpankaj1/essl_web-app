<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $employees = Employee::select('uid', 'userid', 'name', 'role', 'cardno')->orderBy('name', 'asc')->get();
        $employees->transform(function ($employee) {
            $employee->role = $employee->role == 0 ? 'Employee' : $employee->role;
            return $employee;
        });
        return $employees;
    }

    public function headings(): array
    {
        return [
            'UID',
            'User ID',
            'Name',
            'Role',
            'Card No',
        ];
    }
}
