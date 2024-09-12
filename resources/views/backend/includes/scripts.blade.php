<!-- ===============================================-->
<!--    JavaScripts from dashboard-->
<!-- ===============================================-->


<script src="{{ asset('adminassets/assets/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('adminassets/assets/jquery-validation/dist/jquery.validate.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('adminassets/assets/toastr/toastr.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('adminassets/assets/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('adminassets/assets/datatables.net/js/dataTables.responsive.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('adminassets/assets/datatables.net/js/dataTables.buttons.min.js') }}" type="text/javascript"> --}}
</script>
<script src="{{ asset('adminassets/assets/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
{{-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> --}}
<script src="{{ asset('adminassets/vendors/popper/popper.min.js') }}"></script>
<script src="{{ asset('adminassets/vendors/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('adminassets/vendors/anchorjs/anchor.min.js') }}"></script>
<script src="{{ asset('adminassets/vendors/is/is.min.js') }}"></script>
<script src="{{ asset('adminassets/vendors/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('adminassets/vendors/fontawesome/all.min.js') }}"></script>
<script src="{{ asset('adminassets/vendors/lodash/lodash.min.js') }}"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="{{ asset('adminassets/vendors/list.js/list.min.js') }}"></script>
<script src="{{ asset('adminassets/assets/js/theme.js') }}"></script>
{{-- <script src="{{ asset('adminassets/wwwroot/assets/nepali.datepicker.v3.7/js/nepali.datepicker.v3.7.min.js') }}"
    type="text/javascript"></script> --}}
<script src="{{ asset('adminassets/assets/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('adminassets/assets/jquery-mask/dist/jquery.mask.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('adminassets/scripts/language.js') }}"></script>
{{-- <script src="{{ asset('adminassets/scripts/common.js') }}"></script> --}}
<script src="{{ asset('adminassets/assets/js/flatpickr.js') }}"></script>

{{-- Bootstrap 4.0 --}}
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
{{-- Bootstrap 4.0 --}}

<script type="text/javascript">
    InitializeUnicodeNepali();
</script>

<script src="{{ asset('summernote/summernote-lite.min.js') }}"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'Your Content Here..',
        tabsize: 2,
        height: 100,
    });
    $('#summernote1').summernote({
        placeholder: 'Your Content Here..',
        tabsize: 2,
        height: 100,
    });
</script>


<!-- Add jQuery library -->
<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
    crossorigin="anonymous"></script>


<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('adminassets/assets/cropperjs/dist/cropper.css') }}">
<script src="{{ asset('adminassets/assets/cropperjs/dist/cropper.min.js') }}"></script>
<script src="{{ asset('adminassets/assets/js/cropper.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
</script>
{{-- script for pdf --}}
<script>
    document.querySelectorAll('.pdf-input').forEach(function(input) {
        input.addEventListener('change', function(event) {
            var pdfContainerId = input.getAttribute('data-target');
            var pdfContainer = document.getElementById(pdfContainerId);
            pdfContainer.innerHTML = '';

            var file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                var reader = new FileReader();
                reader.onload = function(e) {
                    pdfContainer.innerHTML = '<embed src="' + e.target.result +
                        '" type="application/pdf" width="100%" height="600px" />';
                };
                reader.readAsDataURL(file);
            } else {

                event.target.value = null;
                alert('Please select a valid PDF file.');
            }
        });
    });
</script>



