<?php

namespace App\Http\Services;

use App\Models\TeacherLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherLogService
{
    public function getTeacherLogsForDataTable($request, $school_id = null)
    {
        $qry = TeacherLog::join('users', 'users.id', '=', 'teacher_logs.teacher_log_id')
            ->with(['classes', 'sections', 'subjectGroups', 'subjects', 'lessons', 'topics']) // Eager loading relationships
            ->where('teacher_logs.academic_session_id', session('academic_session_id'))
            ->when(isset($request->class_id), function ($query) use ($request) {
                $query->where('teacher_logs.class_id', $request->class_id);
            })
            ->when(isset($request->section_id), function ($query) use ($request) {
                $query->where('teacher_logs.section_id', $request->section_id);
            })
            ->when(isset($request->subject_group_id), function ($query) use ($request) {
                $query->where('teacher_logs.subject_group_id', $request->subject_group_id);
            })
            ->when(isset($request->subject_id), function ($query) use ($request) {
                $query->where('teacher_logs.subject_id', $request->subject_id);
            })
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('users.id', $request->id);
            });

        if ($school_id) {
            $qry->where('teacher_logs.school_id', $school_id);
        }

        $qry->select('users.f_name', 'users.m_name', 'users.l_name', 'users.email', 'users.username', 'teacher_logs.teacher_log_id as teacher_id', 'teacher_logs.*');

        return $qry->orderBy('teacher_logs.created_at', 'asc')->get();

    }
}