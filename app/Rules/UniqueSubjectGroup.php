<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueSubjectGroup implements Rule
{
    private $classId;
    private $sections;
    private $subjectGroup;

    public function __construct($classId, $sections, $subjectGroup, $recordId = null)
    {
        $this->classId = $classId;
        $this->sections = $sections;
        $this->subjectGroup = $subjectGroup;
        $this->recordId = $recordId;
    }

    public function passes($attribute, $value)
    {
        // Exclude the current record from the check when updating
        // Check if the combination of class, sections, and subjectGroup is unique
        $query = DB::table('subject_group_class')
            ->where('class_id', $this->classId)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('subject_group_section')
                    ->whereColumn('subject_group_section.subject_group_id', 'subject_group_class.subject_group_id')
                    ->whereIn('subject_group_section.section_id', $this->sections);
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('subject_group_subject')
                    ->whereColumn('subject_group_subject.subject_group_id', 'subject_group_class.subject_group_id')
                    ->whereIn('subject_group_subject.subject_id', $this->subjectGroup);
            });

        // Exclude the current record from the check when updating
        if ($this->recordId !== null) {
            $query->where('subject_group_class.subject_group_id', '<>', $this->recordId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The combination of class, section, and subject group is already registered.';
    }
}