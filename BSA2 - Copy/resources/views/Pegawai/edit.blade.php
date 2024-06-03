@extends('../layout/' . $layout)
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Pegawai</h2>
    </div>
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">Edit Pegawai</h2>
        </div>
        <div class="p-5">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="nik" class="form-label w-full flex flex-col sm:flex-row">
                                            NIK <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
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
                                        <input id="nama" type="text" name="nama" class="form-control"
                                            value="{{ $pegawai->nama }}">
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
                                        <label for="alamat" class="form-label w-full flex flex-col sm:flex-row">
                                            Alamat <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <input id="alamat" type="text" name="alamat" class="form-control"
                                            value="{{ $pegawai->alamat }}">
                                        @error('alamat')
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

                                    <div class="input-form mt-3 w-56">
                                        <label for="ttl" class="form-label w-full flex flex-col sm:flex-row">
                                            Tempat Tanggal Lahir <span
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
                                        <input id="jabatan" type="text" name="jabatan" class="form-control"
                                            value="{{ $pegawai->jabatan }}">
                                        @error('jabatan')
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

                                    <div class="input-form mt-3 w-56">
                                        <label for="tanggal_masuk" class="form-label w-full flex flex-col sm:flex-row">
                                            Tanggal Masuk Kerja <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input id="tanggal_masuk" type="text" name="tanggal_masuk"
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
                                            <option value="Menikah" {{ $pegawai->status == 'Menikah' ? 'selected' : '' }}>
                                                Menikah</option>
                                            <option value="Belum Menikah"
                                                {{ $pegawai->status == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah
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
                                            <option value="Kristen" {{ $pegawai->agama == 'Kristen' ? 'selected' : '' }}>
                                                Kristen</option>
                                            <option value="Katolik" {{ $pegawai->agama == 'Katolik' ? 'selected' : '' }}>
                                                Katolik</option>
                                            <option value="Buddha" {{ $pegawai->agama == 'Buddha' ? 'selected' : '' }}>
                                                Buddha</option>
                                            <option value="Hindu" {{ $pegawai->agama == 'Hindu' ? 'selected' : '' }}>
                                                Hindu</option>
                                            <option value="Khonghucu"
                                                {{ $pegawai->agama == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
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
                                        <label for="status_pekerjaan" class="form-label w-full flex flex-col sm:flex-row">
                                            Status Pekerjaan <span
                                                class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                        </label>
                                        <select id="status_pekerjaan" name="status_pekerjaan"
                                            class="form-select mt-2 sm:mr-2" aria-label="Default select example">
                                            <option disabled hidden>Pilih Status Pekerjaan</option>
                                            <option value="Aktif"
                                                {{ $pegawai->status_pekerjaan == 'Aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="Tidak Aktif"
                                                {{ $pegawai->status_pekerjaan == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                                Aktif</option>
                                        </select>
                                        @error('status_pekerjaan')
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
                </div>
                <button type="submit" class="btn btn-primary mt-5">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/preview_foto.js') }}"></script>
@endsection
