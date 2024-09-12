<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentUserService
{
    public function getStudentsForDataTable($request)
    {
        // dd($request);
        return User::join('students', 'users.id', '=', 'students.user_id')
            ->where('users.user_type_id', '=', 8)
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('users.id', $request->id);
            })
            ->select('users.*', 'students.*', 'students.id as student_id')

            ->get();

        // return User::join('students', 'users.id', '=', 'students.user_id')
        //     ->where('users.user_type_id', '=', 8)
        //     ->when(isset($request->id), function ($query) use ($request) {
        //         $query->where('users.id', $request->id);
        //     })
        //     ->when(isset($request->class_id), function ($query) use ($request) {
        //         $query->where('students.class_id', $request->class_id);
        //     })
        //     ->when(isset($request->section_id), function ($query) use ($request) {
        //         $query->where('students.section_id', $request->section_id);
        //     })
        //     ->select('users.*', 'students.*')
        //     ->get();
    }

    // public function getStudentsQuery($classId = null, $sectionId = null)
    // {

    //     $query = Student::query()
    //         ->join('classes', 'students.class_id', '=', 'classes.id')
    //         ->join('sections', 'students.section_id', '=', 'sections.id')
    //         ->select('students.*', 'classes.class', 'sections.section_name');

    //     if ($classId) {
    //         $query->where('students.class_id', $classId);
    //     }

    //     if ($sectionId) {
    //         $query->where('students.section_id', $sectionId);
    //     }

    //     return $query;
    // }
}
