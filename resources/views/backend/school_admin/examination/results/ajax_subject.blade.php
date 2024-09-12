<table class="table table-bordered" id="item_table">
    <thead>
        <tr>
            <th class="">Subject<small class="req"> *</small></th>
            <th class="">Exam Date<small class="req"> *</small></th>
            <th class="">Credit Hours<small class="req"> *</small></th>
            <th class="">Enter Marks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($examSchedule as $schedule)
            <tr>
                <td>{{ $schedule->subjects->subject }}</td>
                <td>{{ $schedule->exam_date }}</td>
                <td>{{ $schedule->credit_hour }}</td>
                <td><span data-toggle="tooltip" title="Exam Marks" data-original-title="Exam Marks">
                    <button type="button" class="btn btn-default btn-xs assignMarks"
                    data-exam_schedule_id="{{ $schedule->id }}"
                    data-exam_id="{{ $schedule->examination_id }}"
                    data-subject_id="{{ $schedule->subject_id }}"
                    data-class_id="{{ $schedule->class_id }}"
                    data-section_id="{{ $schedule->section_id }}"
                    data-subject_group_id="{{ $schedule->subject_group_id }}"
                    autocomplete="off">
                <i class="fa fa-address-card" aria-hidden="true"></i>
            </button><span>
                </td>
                <!-- Add other table cells for schedule information -->
            </tr>
        @endforeach
    </tbody>
</table>
