@extends('../layout/' . $layout)
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Jabatan</h2>
    </div>
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">Edit Jabatan</h2>
        </div>
        <div class="p-5">
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Tempat untuk formulir pegawai -->
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card card-danger">
                                <div class="card-body">
                                    <!-- BEGIN: Validation Form -->
                                    <div class="input-form mt-3">
                                        <label for="deskripsi_jabatan" class="form-label w-full flex flex-col sm:flex-row">
                                            Kode Jabatan<span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <input id="kode_jabatan" type="text" name="kode_jabatan"
                                            class="form-control @error('kode_jabatan') border-danger @enderror"
                                            value="{{ $jabatan->kode_jabatan }}" minlength="2">
                                        @error('kode_jabatan')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input-form mt-3">
                                        <label for="nama_jabatan" class="form-label w-full flex flex-col sm:flex-row">
                                            Nama Jabatan<span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <input id="nama_jabatan" type="text" name="nama_jabatan"
                                            class="form-control @error('nama_jabatan') border-danger @enderror"
                                            value="{{ $jabatan->nama_jabatan }}" minlength="2">
                                        @error('nama_jabatan')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input-form mt-3">
                                        <label for="deskripsi_jabatan" class="form-label w-full flex flex-col sm:flex-row">
                                            Deskripsi Jabatan<span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <textarea id="deskripsi_jabatan" type="text" name="deskripsi_jabatan"
                                            class="form-control @error('deskripsi_jabatan') border-danger @enderror" value="{{ $jabatan->deskripsi_jabatan }}"
                                            minlength="2"></textarea>
                                        @error('deskripsi_jabatan')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-left mt-5">
                        <a id="btn_cancel" type="button"
                            class="btn btn-outline-secondary w-24
                                            mr-1">Batal</a>
                        <button id="btn_save" class="btn btn-primary w-48">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function() {
            async function save() {
                // Loading state
                $('#btn_save').html(
                    '<i data-loading-icon="tail-spin" data-color="white" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "";
            }

            $('#btn_save').on('click', function() {
                save()
            })

            async function cancel() {
                // Loading state
                $('#btn_cancel').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "{{ route('jabatan.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel()
            })

        })()
    </script>
@endsection
