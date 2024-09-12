<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueTopic implements Rule
{
    private $classId;
    private $sections;
    private $subjectGroupId;
    private $subjectId;
    private $lessonId;
    private $topics;

    public function __construct($classId, $sections, $subjectGroupId, $subjectId, $lessonId, $topics, $recordId = null)
    {
        $this->classId = $classId;
        $this->sections = $sections;
        $this->subjectGroupId = $subjectGroupId;
        $this->subjectId = $subjectId;
        $this->lessonId = $lessonId;
        $this->topics = $topics;
        $this->recordId = $recordId;
    }

    public function passes($attribute, $value)
    {
        // Check if the combination of class, sections, and subjectGroup, subject and lesson is unique
        $query = DB::table('topics')
            ->where('class_id', $this->classId)
            ->whereIn('section_id', $this->sections)
            ->where('subject_group_id', $this->subjectGroupId)
            ->where('subject_id', $this->subjectId)
            ->where('lesson_id', $this->lessonId)
            ->whereIn('topic_name', $this->topics);

        // Exclude the current record from the check when updating
        if ($this->recordId !== null) {
            $query->where('id', '<>', $this->recordId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The combination of class, section, and subject group, subject and lesson is already registered.';
    }
}