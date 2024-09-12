<a href="{{ route('admin.mark-sheetdesigns.edit', $mark_sheet_design->id) }}"
    class="btn btn-outline-primary btn-sm mx-1 edit-mark-sheet" data-toggle="tooltip" data-placement="top" title="Edit">
    <i class="fa fa-edit"></i>
</a>



<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
    data-bs-target="#delete{{ $mark_sheet_design->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
    <i class="far fa-trash-alt"></i>
</button>

<div class="modal fade" id="delete{{ $mark_sheet_design->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.mark-sheetdesigns.destroy', $mark_sheet_design->id) }}">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>Are you sure to delete <span class="must" id="underscore">
                            {{ $mark_sheet_design->name }}</span> ? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-primary btn-sm  mx-1" data-toggle="modal"
    onclick="openMarkSheetModal({{ json_encode($mark_sheet_design) }})">
    <i class="fa fa-eye"></i>
</button>

<script>
    function openMarkSheetModal(data) {
    // Populate modal fields with dynamic data

    $('#exampleModal').modal('show');
    // Example of populating modal fields with dynamic data
    $('#modalHeading').text(data.heading);
    $('#modalExamName').text(data.exam_name);
    $('#modalSchoolName').text(data.school_name);
    $('#modalExamCenter').text(data.exam_center);
 // Set left logo
 $('#modalLeftLogo').attr('src', '/uploads/students/mark_sheet/' + data.left_logo);
 $('#modalRightLogo').attr('src', '/uploads/students/mark_sheet/' + data.right_logo);
 $('#modalLeftSign').attr('src', '/uploads/students/mark_sheet/' + data.left_sign);
 $('#modalRightSign').attr('src', '/uploads/students/mark_sheet/' + data.right_sign);
 $('#modalMiddleSign').attr('src', '/uploads/students/mark_sheet/' + data.middle_sign);
 $('#modalContent').css('background-image', 'url("/uploads/students/mark_sheet/' + data.background_img + '")');
// $('#backgroundContainer').css('background-image', 'url("/uploads/students/mark_sheet/' + data.background_img + '")');

    // Add similar lines to populate other fields as needed

      // Check boolean fields and show/hide elements accordingly
      if (data.is_classteacher_remarks) {
            $('#classteacherRemarks').show(); // Show element with ID 'classteacherRemarks'
        } else {
            $('#classteacherRemarks').hide(); // Hide element with ID 'classteacherRemarks'
        }

        // FOR NAME
      if (data.is_name) {
            $('#isName').show();
        } else {
            $('#isName').hide();
        }

        // FOR FATHER NAME
      if (data.is_father_name) {
            $('#isFatherName').show();
        } else {
            $('#isFatherName').hide();
        }

        // FOR PHOTO
       if (data.is_photo) {
            $('#isPhoto').show();
        } else {
            $('#isPhoto').hide();
        }

           // FOR MOTHER NAME
       if (data.is_mother_name) {
            $('#isMotherName').show();
        } else {
            $('#isMotherName').hide();
        }

              // FOR MOTHER NAME
       if (data.is_dob) {
            $('#isDob').show();
        } else {
            $('#isDob').hide();
        }

        // FOR ADMISSION NUMBER
        if (data.is_admission_no) {
            $('#isAdmissionNumber').show();
        } else {
            $('#isAdmissionNumber').hide();
        }

          // FOR ROLL NUMBER
          if (data.is_roll_no) {
            $('#isRollNumber').show();
        } else {
            $('#isRollNumber').hide();
        }


          // FOR ADDRESS
          if (data.is_address) {
            $('#isAddress').show();
        } else {
            $('#isAddress').hide();
        }

        // FOR GENDER
        if (data.is_gender) {
            $('#isGender').show();
        } else {
            $('#isGender').hide();
        }

          // FOR GENDER
          if (data.is_division) {
            $('#isDivision').show();
        } else {
            $('#isDivision').hide();
        }

          // FOR RANK
        if (data.is_rank) {
            $('#isRank').show();
        } else {
            $('#isRank').hide();
        }

        // FOR CUSTOM FIELD
        if (data.is_custom_field) {
            $('#isCustomField').show();
        } else {
            $('#isCustomField').hide();
        }

          // FOR CLASS
          if (data.is_class) {
            $('#isClass').show();
        } else {
            $('#isClass').hide();
        }

           // FOR CLASS
        if (data.is_session) {
            $('#isSession').show();
        } else {
            $('#isSession').hide();
        }







}
</script>