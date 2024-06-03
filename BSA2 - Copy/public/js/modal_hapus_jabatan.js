document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function() {
        // Mengambil id pegawai dari atribut data
        let jabatanId = this.getAttribute('data-jabatan-id');

        // Mengatur action form hapus dalam modal berdasarkan id pegawai yang dipilih
        document.getElementById('form_modal').setAttribute('action', '/jabatan/' + jabatanId);
    });
});
