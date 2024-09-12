@extends('backend.layouts.master')

<!-- Main content -->
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">

            <div class="border-bottom border-primary">
                <h2>
                    {{ $page_title }}

                </h2>
            </div>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">

                        <form id="filterForm">
                            @csrf


                            <div class="row">
                                <!-- Class Dropdown -->
                                <div class="col-sm-4">
                                    <label>Class</label><small class="req"> *</small>
                                    <div class="form-group select">
                                        <select name="class_id">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}" {{ $class->id == $examTeacher->class_id ? 'selected' : '' }}>
                                                    {{ $class->class }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                                        <!-- Section Dropdown -->
                            <div class="col-sm-4">
                                <label>Section</label><small class="req"> *</small>
                                <div class="form-group select">
                                    <select name="section_id" id="dynamic_section_id" class="input-text single-input-text">
                                        <option disabled>Select Section</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" {{ $section->id == $examTeacher->section_id ? 'selected' : '' }}>
                                                {{ $section->section_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('section_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>



                                <!-- Teacher Dropdown -->
                                <div class="col-sm-4">
                                    <label>Teacher</label><small class="req"> *</small>
                                    <div class="form-group select">
                                        <select name="user_id">
                                            <option value="">Select Teacher</option>
                                            @foreach ($teachers as $id => $teacher)
                                                <option value="{{ $id }}" {{ $id == $examTeacher->user_id ? 'selected' : '' }}>
                                                    {{ $teacher }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="form-group col-md-12 d-flex justify-content-end pt-2">
                                <button type="button" class="btn btn-primary" id="updateButton">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>


        @section('scripts')
        <script>
            $(document).ready(function() {
                $('#updateButton').click(function() {
                    // Get the selected class ID, section ID, teacher ID, and examination ID
                    var classId = $('select[name="class_id"]').val();
                    var sectionId = $('select[name="section_id"]').val();
                    var teacherId = $('select[name="user_id"]').val();
                    var examinationId = $('#examination_id').val();


                    console.log('examination:', examinationId);
                    console.log('teacher:', teacherId);
                    console.log('class:', classId);
                    console.log('section:', sectionId);

   // Send an AJAX request to save the assigned teacher data
                    $.ajax({
                        url: '{{ route('admin.assign-teachers.update', $examTeacher->id) }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        data: {
                            examination_id: examinationId,
                            class_id: classId,
                            section_id: sectionId,
                            user_id: teacherId,

                        },

                        success: function(response) {
                            // Handle the response (e.g., show a success message)
                            if (response.message) {
                                // If there's a success message in the response, display it
                                toastr.success(response.message);
                            } else {
                                // If no success message is provided, display a default success message
                                toastr.success('Teacher assigned successfully');
                            }
                            // Redirect to the previous page
                            window.location.href = document.referrer;
                        },
                        error: function(error) {
                            // Handle errors (e.g., show an error message)
                            console.error(error);
                            toastr.error('Error occurred while assigning teacher. Please try again later.');
                        }
                    });
                });

                // Function to populate sections based on the selected class
                $('select[name="class_id"]').change(function() {
                    var classId = $(this).val();
                    $.ajax({
                        url: baseURL + '/admin/get-section-by-class/' +
                         classId,
                        type: 'GET',
                        data: {
                            class_id: classId
                        },
                        success: function(data) {
                            $('select[name="section_id"]').empty().append('<option disabled selected>Select Section</option>');
                            $.each(data, function(key, value) {
                                $('select[name="section_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });
            });
        </script>




    @endsection
@endsection
