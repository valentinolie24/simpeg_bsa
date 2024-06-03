// import Pristine from "pristinejs";
// import Toastify from "toastify-js";
// import $ from "jquery"; // Import jQuery

// $(document).ready(function () {
//     "use strict";

//     function onSubmit(pristine) {
//         // Kosongkan fungsi onSubmit
//     }
    


//     $(".validate-form").each(function () {
//         let pristine = new Pristine(this, {
//             classTo: "input-form",
//             errorClass: "has-error",
//             errorTextParent: "input-form",
//             errorTextClass: "text-danger mt-2",
//         });
    
//         $(this).on("submit", function (e) {
//             e.preventDefault();
    
//             // Lakukan validasi menggunakan Pristine.js
//             let valid = pristine.validate();
    
//             // Jika validasi berhasil, kirim data formulir ke server
//             if (valid) {
//                 // Dapatkan URL tujuan dari atribut "action" formulir
//                 let url = $(this).attr('action');
    
//                 // Dapatkan data formulir
//                 let formData = $(this).serialize();
    
//                 // Kirim data formulir ke server menggunakan AJAX
//                 $.ajax({
//                     type: 'POST',
//                     url: url,
//                     data: formData,
//                     success: function (response) {
//                         // Tanggapan sukses dari server, tampilkan toast berhasil
//                         Toastify({
//                             node: $("#success-notification-content")
//                                 .clone()
//                                 .removeClass("hidden")[0],
//                             duration: 3000,
//                             newWindow: true,
//                             close: true,
//                             gravity: "top",
//                             position: "right",
//                             stopOnFocus: true,
//                         }).showToast();
//                     },
//                     error: function (xhr, status, error) {
//                         // Tanggapan error dari server, tampilkan toast gagal
//                         Toastify({
//                             node: $("#failed-notification-content")
//                                 .clone()
//                                 .removeClass("hidden")[0],
//                             duration: 3000,
//                             newWindow: true,
//                             close: true,
//                             gravity: "top",
//                             position: "right",
//                             stopOnFocus: true,
//                         }).showToast();
//                         console.error(xhr.responseText);
//                     }
//                 });
//             } else {
//                 // Jika validasi gagal, tampilkan toast gagal
//                 Toastify({
//                     node: $("#failed-notification-content")
//                         .clone()
//                         .removeClass("hidden")[0],
//                     duration: 3000,
//                     newWindow: true,
//                     close: true,
//                     gravity: "top",
//                     position: "right",
//                     stopOnFocus: true,
//                 }).showToast();
//             }
//         });
//     });
    
// });
