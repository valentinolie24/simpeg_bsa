{{-- modal --}}
{{-- <div class="modal fade" id="hapus_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST" id="form_modal">
                @method('DELETE')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="modal-body" id="isi-modal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<!-- BEGIN: Modal Content -->
@if ($pegawais->isEmpty())
@else
    <!-- BEGIN: Modal Content -->
    <div id="hapus_modal" class="modal" tabindex="-1" aria-hidden="true">
        <!-- Modal Content -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" id="form_modal">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Konfirmasi Hapus?</div>
                            <div class="text-slate-500 mt-2">Apakah yakin ingin menghapus data ini? <br>Data yang sudah
                                dihapus tidak bisa dikembalikan</div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">Batal</button>
                            <button type="submit" class="btn btn-danger w-24">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->
@endif
<!-- END: Modal Content -->
