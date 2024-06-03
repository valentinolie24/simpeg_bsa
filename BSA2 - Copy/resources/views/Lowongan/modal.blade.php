<!-- BEGIN: Modal Content -->
@if ($lowongans->isEmpty())
@else
    <!-- BEGIN: Modal Content -->
    <div id="hapus_modal" class="modal" tabindex="-1" aria-hidden="true">
        <!-- Modal Content -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" id="form_modal">
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
