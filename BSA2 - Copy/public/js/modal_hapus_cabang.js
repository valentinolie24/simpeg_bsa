document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function() {
        // Mengambil id pegawai dari atribut data
        let cabangId = this.getAttribute('data-cabang-id');

        // Mengatur action form hapus dalam modal berdasarkan id pegawai yang dipilih
        document.getElementById('form_modal').setAttribute('action', '/cabang/' + cabangId);
    });
});
