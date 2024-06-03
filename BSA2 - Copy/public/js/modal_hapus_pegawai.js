// Menambahkan event listener untuk tombol hapus pada setiap item pegawai
document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function() {
        // Mengambil id pegawai dari atribut data
        let pegawaiId = this.getAttribute('data-pegawai-id');

        // Mengatur action form hapus dalam modal berdasarkan id pegawai yang dipilih
        document.getElementById('form_modal').setAttribute('action', '/pegawai/' + pegawaiId);
    });
});


