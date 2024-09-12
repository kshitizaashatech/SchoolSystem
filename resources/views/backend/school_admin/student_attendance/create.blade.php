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
            @include('backend.school_admin.student.action')
        </div>


        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12">


                            {{-- Select Form Starts --}}
                            {{-- Please uncomment the below code once you have got the data --}}


                            {{-- <div class="hr-line-dashed"></div>
                            <h5>Class and Section Selection:</h5>
                            <div class="hr-line-dashed"></div>
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <label for="state_id">Choose Class</label>

                                    <select id="class_id" name="class_id" data-iteration="0" class="class_id"
                                        required>
                                        <option disabled selected value="{{ old('class_id') }}">Choose Class
                                        </option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="">
                                    <label for="section_id">Choose Section</label>

                                    <select id="section_id" name="section_id" data-iteration="0"
                                        class="section_id" required>
                                        <option value="{{ old('section_id') }}">Choose Section</option>
                                    </select>
                                    @error('section_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                            </div> --}}

{{-- Select Form Ends --}}


                            <div class="report-table-container">

                                <div class="table-responsive">
                                    <table id="attendance-type-table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Admission No.</th>
                                                <th>Roll No.</th>
                                                <th>Name</th>
                                                <th>Attendace</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            
                                            <tr>
                                                <td>1</td>
                                                <td>1234</td>
                                                <td>1</td>
                                                <td>Ram Prasad Sharma</td>
                                                <td>
                                                    <form>
                                                        <fieldset>
                                                         
                                                          <div>
                                                            <input type="radio" id="present" name="present" value="present" />
                                                            <label for="contactChoice1">Present</label>
                                                      
                                                            <input type="radio" id="absent" name="absent" value="absent" />
                                                            <label for="contactChoice2">Phone</label>
                                                      

                                                          </div>

                                                        </fieldset>
                                                      </form>
                                                </td>
                                                <td>
                                                    <input type="text" name="" class="form-control">
                                                </td>

                                            </tr>
                                        </tbody>


                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






    </div>

    @include('backend.includes.modal')
    @endsection
    {{-- @section('scripts')
        @include('backend.includes.cropperjs')
    
    
    @endsection --}}

    
    