<div>
    <a href="{{ url()->previous() }}"><button class="btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
            Back</button></a>
    @can('list_student_attendances')
        <a href="{{ route('admin.student-attendances.index') }}"><button class="btn-info btn-sm">All List <i
                    class="fa fa-list"></i></button></a>
    @endcan
    
    {{-- @can('create_student_attendances')
        <a href="#">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#createAttendanceType">
                Add Student Attendance <i class="fas fa-plus"></i>
            </button>
        </a>
    @endcan --}}

     <!-- Add the new button for marking holiday for entire school -->
    
        <button type="button" class="btn-primary btn-sm" id="markSchoolHolidayButton">Mark Holiday for Entire School</button>
        <button type="button" class="btn-primary btn-sm" id="markHolidayRangeButton">Mark Holiday Range</button>

</div>
