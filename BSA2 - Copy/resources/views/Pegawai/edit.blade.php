@extends('../layout/' . $layout)
@section('subhead')
    <title>Pegawai</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Pegawai</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Ubah Informasi Pegawai</h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="input-form">
                                            <label for="nik" class="form-label w-full flex flex-col sm:flex-row">
                                                NIK <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input id="nik" type="text" name="nik" class="form-control"
                                                value="{{ $pegawai->nik }}">
                                            @error('nik')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="nama" class="form-label w-full flex flex-col sm:flex-row">
                                                Nama <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input disabled id="nama" type="text" name="nama"
                                                class="form-control" value="{{ $pegawai->nama }}">
                                            @error('nama')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="input-form mt-3">
                                            <label for="status" class="form-label w-full flex flex-col sm:flex-row">
                                                Status <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="status" name="status" class="form-select mt-2 sm:mr-2"
                                                aria-label="Default select example">
                                                <option disabled hidden>Pilih Status</option>
                                                <option value="Menikah"
                                                    {{ $pegawai->status == 'Menikah' ? 'selected' : '' }}>
                                                    Menikah</option>
                                                <option value="Belum Menikah"
                                                    {{ $pegawai->status == 'Belum Menikah' ? 'selected' : '' }}>
                                                    Belum Menikah
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="input-form mt-3">
                                            <label for="agama" class="form-label w-full flex flex-col sm:flex-row">
                                                Agama <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="agama" name="agama" class="form-select mt-2 sm:mr-2"
                                                aria-label="Default select example">
                                                <option disabled hidden>Pilih Agama</option>
                                                <option value="Islam" {{ $pegawai->agama == 'Islam' ? 'selected' : '' }}>
                                                    Islam</option>
                                                <option value="Kristen"
                                                    {{ $pegawai->agama == 'Kristen' ? 'selected' : '' }}>
                                                    Kristen</option>
                                                <option value="Katolik"
                                                    {{ $pegawai->agama == 'Katolik' ? 'selected' : '' }}>
                                                    Katolik</option>
                                                <option value="Buddha" {{ $pegawai->agama == 'Buddha' ? 'selected' : '' }}>
                                                    Buddha</option>
                                                <option value="Hindu" {{ $pegawai->agama == 'Hindu' ? 'selected' : '' }}>
                                                    Hindu</option>
                                                <option value="Khonghucu"
                                                    {{ $pegawai->agama == 'Khonghucu' ? 'selected' : '' }}>
                                                    Khonghucu</option>
                                            </select>
                                            @error('agama')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="input-form mt-3">
                                            <label for="status_pekerjaan"
                                                class="form-label w-full flex flex-col sm:flex-row">
                                                Status Pekerjaan <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="status_pekerjaan" name="status_pekerjaan"
                                                class="form-select mt-2 sm:mr-2" aria-label="Default select example">
                                                <option disabled hidden>Pilih Status Pekerjaan</option>
                                                <option value="Aktif"
                                                    {{ $pegawai->status_pekerjaan == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="Tidak Aktif"
                                                    {{ $pegawai->status_pekerjaan == 'Tidak Aktif' ? 'selected' : '' }}>
                                                    Tidak
                                                    Aktif</option>
                                            </select>
                                            @error('status_pekerjaan')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon"
                                                        class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="input-form mt-3">
                                            <label for="tempat_lahir" class="form-label w-full flex flex-col sm:flex-row">
                                                Tempat Lahir <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input id="tempat_lahir" type="text" name="tempat_lahir"
                                                class="form-control" value="{{ $pegawai->tempat_lahir }}">
                                            @error('tempat_lahir')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon"
                                                        class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="input-form mt-3 w-56">
                                            <label for="ttl" class="form-label w-full flex flex-col sm:flex-row">
                                                Tanggal Lahir <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                                </div>
                                                <input id="ttl" type="text" name="ttl"
                                                    class="datepicker form-control pl-12" data-single-mode="true"
                                                    value="{{ $pegawai->ttl }}" required>
                                            </div>
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="jabatan" class="form-label w-full flex flex-col sm:flex-row">
                                                Jabatan <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input disabled id="jabatan" type="text" name="jabatan"
                                                class="form-control" value="{{ $pegawai->jabatan }}">
                                            @error('jabatan')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon"
                                                        class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-form mt-3 w-56">
                                            <label for="tanggal_masuk"
                                                class="form-label w-full flex flex-col sm:flex-row">
                                                Tanggal Masuk Kerja <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                                </div>
                                                <input disabled id="tanggal_masuk" type="text" name="tanggal_masuk"
                                                    class="datepicker form-control pl-12" data-single-mode="true"
                                                    value="{{ $pegawai->tanggal_masuk }}" required>
                                            </div>
                                        </div>

                                        <div class="input-form mt-3">
                                            <label for="pendidikan" class="form-label w-full flex flex-col sm:flex-row">
                                                Pendidikan <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input id="pendidikan" type="text" name="pendidikan" class="form-control"
                                                value="{{ $pegawai->pendidikan }}">
                                            @error('pendidikan')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon"
                                                        class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
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
                                                        src="{{ asset($pegawai->foto ? 'foto/' . $pegawai->foto : 'dist/images/placeholder.jpg') }}">
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
                                                            <button type="button" class="btn-close"
                                                                data-tw-dismiss="alert" aria-label="Close">
                                                                <i data-lucide="x" class="w-4 h-4"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div class="input-form mt-3">
                                            <label for="alamat" class="form-label w-full flex flex-col sm:flex-row">
                                                Alamat <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <textarea id="alamat" type="text" name="alamat" class="form-control">{{ $pegawai->alamat }}</textarea>
                                            @error('alamat')
                                                <div class="alert alert-danger-soft show flex items-center mt-1 mb-2"
                                                    role="alert">
                                                    <i data-lucide="alert-octagon"
                                                        class="w-6 h-6 mr-2"></i>{{ $message }}
                                                    <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                        aria-label="Close">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left mt-5">
                                    <a id="btn_cancel" class="btn btn-outline-secondary w-24 mr-1">
                                        Cancel
                                    </a>
                                    <button id="btn_save" type="submit" class="btn btn-primary w-24">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                window.location.href = "{{ route('pegawai.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel()
            })

        })()
    </script>
@endsection
