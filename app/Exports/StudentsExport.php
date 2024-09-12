<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class StudentsExport implements FromQuery, WithHeadings
{
    protected $classId;
    protected $sectionId;

    public function __construct($classId = null, $sectionId = null)
    {
        $this->classId = $classId;
        $this->sectionId = $sectionId;
    }

    public function query()
    {
        $query = Student::query()
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->join('sections', 'students.section_id', '=', 'sections.id')
            ->select(
                'students.roll_no',
                'students.admission_no as admission_id',
                DB::raw("CONCAT(users.f_name, ' ', users.l_name) as full_name"),
                'users.gender',
                'users.father_name as father_name',
                'users.mother_name as mother_name',
                'classes.class as current_class',
                'sections.section_name as section',
                DB::raw('YEAR(students.created_at) as year'),
                'users.dob as dob'
                
            );

        if ($this->classId && $this->sectionId) {
            $query->where('students.class_id', $this->classId)
                  ->where('students.section_id', $this->sectionId);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ROLL No',
            'Admission Id',
            'FullName',
            'Gender',
            'Father Name',
            'Mother Name',
            'CurrentClass',
            'Section',
            'Year',
            'DOB'
        ];
    }
}