<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueLogBookDate implements Rule
{
    private $classId;
    private $sections;
    private $subjectGroupId;
    private $subjectId;
    private $lessonId;
    private $topicId;
    private $logBookDate;

    public function __construct($classId, $sections, $subjectGroupId, $subjectId, $lessonId, $topicId, $logBookDate, $recordId = null)
    {
        $this->classId = $classId;
        $this->sections = $sections;
        $this->subjectGroupId = $subjectGroupId;
        $this->subjectId = $subjectId;
        $this->lessonId = $lessonId;
        $this->topicId = $topicId;
        $this->logBookDate = $logBookDate;
        $this->recordId = $recordId;
    }

    public function passes($attribute, $value)
    {
        // dd($this->recordId);
        // Exclude the current record from the check when updating
        // Check if the combination of class, sections, and subjectGroup, subject and lesson is unique
        $query = DB::table('teacher_logs')
            ->where('class_id', $this->classId)
            ->whereIn('section_id', $this->sections)
            ->where('subject_group_id', $this->subjectGroupId)
            ->where('subject_id', $this->subjectId)
            ->where('lesson_id', $this->lessonId)
            ->where('topic_id', $this->topicId)
            ->where('log_book_date', $this->logBookDate);

        // Exclude the current record from the check when updating
        if ($this->recordId !== null) {
            $query->where('id', '<>', $this->recordId);
        }
        // dd($query->exists());
        return !$query->exists();
    }

    public function message()
    {
        return 'Sorry Log for the date you entered is Already Registered.';
    }
}