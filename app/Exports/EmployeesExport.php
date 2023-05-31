<?php
namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function collection()
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Date of Birth',
            'Date of Joining',
            'Gender',
            'Designation',
            'Manager',
            'Employee Picture',
            'Email',
            'Created At',
            'Updated At',
        ];
    }
}


