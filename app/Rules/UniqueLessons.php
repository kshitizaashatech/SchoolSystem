<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueLessons implements Rule
{
    private $classId;
    private $sections;
    private $subjectGroupId;
    private $subjectId;
    private $lessons;

    public function __construct($classId, $sections, $subjectGroupId, $subjectId, $lessons, $recordId = null)
    {
        $this->classId = $classId;
        $this->sections = $sections;
        $this->subjectGroupId = $subjectGroupId;
        $this->subjectId = $subjectId;
        $this->lessons = $lessons;
        $this->recordId = $recordId;
    }

    public function passes($attribute, $value)
    {
        // Exclude the current record from the check when updating
        // Check if the combination of class, sections, and subjectGroup is unique
        $query = DB::table('lessons')
            ->where('class_id', $this->classId)
            ->whereIn('section_id', $this->sections)
            ->where('subject_group_id', $this->subjectGroupId)
            ->where('subject_id', $this->subjectId);

        // Exclude the current record from the check when updating
        if ($this->recordId !== null) {
            $query->where('id', '<>', $this->recordId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The combination of class, section, and subject group is already registered.';
    }
}