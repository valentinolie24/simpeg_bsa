@extends('../layout/' . $layout)
@section('subhead')
    <title>Lowongan</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Lowongan</h2>
    </div>
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">Edit Lowongan</h2>
        </div>
        <div class="p-5">
            <form action="{{ route('lowongan.update', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Tempat untuk formulir pegawai -->
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card card-danger">
                                <div class="card-body">
                                    <!-- BEGIN: Validation Form -->
                                    <div class="input-form">
                                        <label for="posisi" class="form-label w-full flex flex-col sm:flex-row">
                                            Posisi <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        {{-- <select id="posisi" name="posisi"
                                            class="form-select @error('posisi') border-danger @enderror">
                                            <option selected disabled hidden value="">Pilih Jabatan</option>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->nama_jabatan }}">{{ $jabatan->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <input disabled id="posisi" type="text" name="posisi"
                                            class="form-control @error('posisi') border-danger @enderror"
                                            value="{{ $lowongan->posisi }}">
                                        @error('posisi')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-form mt-3">
                                        <label for="deskripsi" class="form-label w-full flex flex-col sm:flex-row">
                                            Deskripsi <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <textarea id="deskripsi" type="text" name="deskripsi"
                                            class="form-control @error('deskripsi') border-danger @enderror">{{ $lowongan->deskripsi }}</textarea>
                                        @error('deskripsi')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-form mt-3">
                                        <label for="gaji" class="form-label w-full flex flex-col sm:flex-row">
                                            Kisaran Gaji <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <select id="gaji" name="gaji"
                                            class="form-select mt-2 sm:mr-2 @error('gaji') border-danger @enderror">
                                            aria-label="Default select example">
                                            <option disabled hidden>Pilih kisaran gaji</option>
                                            <option value="Rp.1.000.000 - Rp.2.000.000"
                                                {{ $lowongan->gaji == 'Rp.1.000.000 - Rp.2.000.000' ? 'selected' : '' }}>
                                                Rp.1.000.000 - Rp.2.000.000
                                            </option>
                                            <option value="Rp.2.000.000 - Rp.3.000.000"
                                                {{ $lowongan->gaji == 'Rp.2.000.000 - Rp.3.000.000' ? 'selected' : '' }}>
                                                Rp.2.000.000 - Rp.3.000.000
                                            </option>
                                            <option value="Rp.3.000.000 - Rp.4.000.000"
                                                {{ $lowongan->gaji == 'Rp.3.000.000 - Rp.4.000.000' ? 'selected' : '' }}>
                                                Rp.3.000.000 - Rp.4.000.000
                                            </option>
                                            <option value="Rp.4.000.000 - Rp.5.000.000"
                                                {{ $lowongan->gaji == 'Rp.4.000.000 - Rp.5.000.000' ? 'selected' : '' }}>
                                                Rp.4.000.000 - Rp.5.000.000
                                            </option>
                                        </select>
                                        @error('gaji')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-form mt-3 w-72">
                                        <label for="foto" class="form-label w-full flex flex-col sm:flex-row">
                                            Foto <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <div
                                            class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                            <div class="text-slate-500 text-center font-medium mt-2">
                                                <img id="previewFoto" class="rounded-md" alt="Preview Foto"
                                                    src="{{ asset($lowongan->foto ? 'foto/' . $lowongan->foto : 'dist/images/placeholder.jpg') }}">
                                            </div>
                                            <div class="mx-auto cursor-pointer relative mt-5">
                                                <button type="button" class="btn btn-primary w-full"
                                                    onclick="document.getElementById('inputFoto').click()">Pilih
                                                    Foto</button>
                                                <input id="foto" type="file" name="foto"
                                                    class="w-full h-full top-0 left-0 absolute opacity-0"
                                                    onchange="previewImage(this)">
                                                @if ($errors->has('foto'))
                                                    <div class="alert alert-outline-danger alert-dismissible show flex items-center mb-2"
                                                        role="alert">
                                                        <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                                                        {{ $errors->first('foto') }}
                                                        <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                            aria-label="Close">
                                                            <i data-lucide="x" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
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
    <script src="{{ asset('js/preview_foto.js') }}"></script>
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
                window.location.href = "{{ route('lowongan.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel()
            })

        })()
    </script>
@endsection
