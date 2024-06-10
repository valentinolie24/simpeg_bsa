@extends('../layout/' . $layout)
@section('subhead')
    <title>Jabatan</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Jabatan</h2>
    </div>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-5">
        <a type="button" href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_jabatan" class="btn btn-primary"
            style="width: 150px; height: 40px;">Tambah Jabatan</a>
        <div class="hidden md:block mx-auto text-slate-500">

        </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <form action="{{ route('cari_lowongan') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="nama_pencarian" name="nama_pencarian" type="text"
                        class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Jabatan...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Cari</button>
                    <a type="button" id="reset_pencarian" href="{{ route('lowongan.index') }}"
                        class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset</a>
                </div>
            </form>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('delete'))
                            <div class="alert alert-outline-danger show flex items-center mb-2" role="alert">
                                <i data-lucide="x" class="w-6 h-6 mr-2"></i> {{ session()->get('delete') }}
                                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('success'))
                            <div class="alert alert-outline-success show flex items-center mb-2" role="alert">
                                <i data-lucide="check" class="w-6 h-6 mr-2"></i> {{ session()->get('success') }}
                                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_jabatan" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="jabatanForm" action="{{ route('jabatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h2 class="text-lg font-medium mr-auto">Tambah Jabatan</h2>
                        <button type="button" class="close" data-tw-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-10">

                        <div class="input-form mt-3">
                            <label for="deskripsi_jabatan" class="form-label w-full flex flex-col sm:flex-row">
                                Kode Jabatan<span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                            </label>
                            <input id="kode_jabatan" type="text" name="kode_jabatan"
                                class="form-control @error('kode_jabatan') border-danger @enderror"
                                placeholder="Kode Jabatan" value="{{ old('kode_jabatan') }}" minlength="2">
                            @error('kode_jabatan')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-form mt-3">
                            <label for="nama_jabatan" class="form-label w-full flex flex-col sm:flex-row">
                                Nama Jabatan<span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                            </label>
                            <input id="nama_jabatan" type="text" name="nama_jabatan"
                                class="form-control @error('nama_jabatan') border-danger @enderror"
                                placeholder="Nama Jabatan" value="{{ old('nama_jabatan') }}" minlength="2">
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
                                class="form-control @error('deskripsi_jabatan') border-danger @enderror" placeholder="Deskripsi Jabatan"
                                minlength="2">{{ old('deskripsi_jabatan') }}</textarea>
                            @error('deskripsi_jabatan')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-2" data-tw-dismiss="modal">Tutup</button>
                        <button type="submit" form="jabatanForm" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($jabatans->isEmpty())
        <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
    @else
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            @php $no = 1; @endphp
            @foreach ($jabatans as $jabatan)
                <div class="intro-y col-span-12 md:col-span-3">
                    <div class="box zoom-in">
                        <div class="flex flex-col lg:flex-row items-center p-5">
                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                <span class="font-medium">Jabatan {{ $jabatan->nama_jabatan }}</span>
                                <div class="text-slate-500 text-xs mt-0.5">Kode : {{ $jabatan->kode_jabatan }}</div>
                                <div class="text-slate-500 text-xs mt-0.5">Deskripsi : {{ $jabatan->deskripsi_jabatan }}
                                </div>
                            </div>
                            <div class="flex mt-4 lg:mt-0">
                                <div class="dropdown ml-3">
                                    <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500"
                                        aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">

                                            <li>
                                                <a href="{{ url('jabatan/' . $jabatan->id . '/edit') }}"
                                                    class="dropdown-item">
                                                    <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit Jabatan
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#hapus_modal" class="dropdown-item btn-hapus"
                                                    data-jabatan-id="{{ $jabatan->id }}">
                                                    <i data-lucide="trash" class="w-4 h-4 mr-2"></i> Hapus
                                                    Jabatan
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @include('Jabatan.modal')
    <script src="js/modal_hapus_jabatan.js"></script>
    <script src="js/pencarian.js"></script>
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                $('#modal_jabatan').modal('show');
            @endif
        });
    </script>
@endsection
