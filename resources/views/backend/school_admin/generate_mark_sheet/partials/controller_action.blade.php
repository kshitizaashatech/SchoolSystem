{{-- controller_action.blade.php --}}
<div class="btn-group d-flex gap-2">
    <a href="#" class="btn btn-outline-primary btn-sm mx-1 show-mark-sheet-design"
        data-student-id="{{ $student->student_id }}" data-class-id="{{ $student->class_id }}"
        data-section-id="{{ $student->section_id }}" data-marksheet-design-id="{{ $marksheet_design_id }}"
        data-examination-id="{{ $examination_id }}" data-toggle="tooltip" data-placement="top" title="Show">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('admin.downloadstudentmarksheet.get', ['student_id' => $student->student_id, 'class_id' => $student->class_id, 'section_id' => $student->section_id, 'marksheetdesign_id' => $marksheet_design_id, 'examination_id' => $examination_id]) }}"
        class="btn btn-outline-primary btn-sm mx-1 download-mark-sheet"data-toggle="tooltip" data-placement="top"
        title="Download" target="_blank"><i class="fa fa-download"></i></a>
</div>
