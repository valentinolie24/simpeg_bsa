// preview_foto.js

// Function to preview image
function previewImage(input) {
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewFoto').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

// // Function to remove image preview
// function removeImagePreview() {
//     document.getElementById('previewFoto').src = "{{ asset('dist/images/placeholder.jpg') }}";
// }

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewFoto').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}