<script>
    function readFile() {
        var input = $(this);
        if (input.data('ratio')) {
            var ratio_l = input.data('ratio');
            var ratio_w = input.data('ratiowidth');
            // var aspectRatio = 16 / 12;
            var aspectRatio = ratio_l / ratio_w;

            //                var aspectRatio = ratio[9] / ratio[16];
        }
        if (this.files && this.files[0]) {
            var FR = new FileReader();
            FR.addEventListener("load", function(e) {
                imgBase = e.target.result;

                $('#imageCropperModal').modal('show');

                $('#cropImgSrc').attr('src', imgBase).cropper({
                    aspectRatio: aspectRatio,
                    viewMode: 1,
                });
            });
            FR.readAsDataURL(this.files[0]);
        }
    }

    document.getElementById("imageFile").addEventListener("change", readFile);
    $('#imageCropperModal').on('hidden.bs.modal', function() {
        $('#cropImgSrc').cropper('destroy');
    });
    $('#saveCroppedImg').on('click', function() {

        var orgImageDetails = $('#cropImgSrc').cropper('getImageData');
        var height = orgImageDetails.naturalHeight;
        var width = orgImageDetails.naturalWidth;
        var exportResolution = {
            height: height,
            width: width
        };

        exportResolution = {
            height: 1280,
            width: 720
        };
        var croppedImgSrc = $('#cropImgSrc').cropper('getCroppedCanvas', exportResolution).toDataURL();
        $('#croppedImagePreview').attr('src', croppedImgSrc);
        $('#inputCroppedPic').attr('value', croppedImgSrc);
        $('#imageCropperModal').modal('hide');
        $('#previewWrapper').removeClass('hidden');
        $('#previewWrapper1').addClass('hidden');
        $('#editImageView').hide()
    });
    $('#removeCroppedImage').on('click', function() {
        $('#croppedImagePreview').attr('src', '');
        $('#inputCroppedPic').attr('value', '');
        $('#imageFile').val('');
        $('#previewWrapper').addClass('hidden');
        $('#previewWrapper1').removeClass('hidden');
        $('#editImageView').show()
        $('#croppedImagePreviewPre').show();
    });
    $(document).on('click', '#imageFile', function() {
        $('#croppedImagePreviewPre').hide();
    })
</script>
