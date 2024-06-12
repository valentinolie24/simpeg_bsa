@extends('../layout/' . $layout)
@section('subhead')
    <title>Cabang</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Cabang</h2>
    </div>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-5">
        <a type="button" href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_cabang" class="btn btn-primary"
            style="width: 150px; height: 40px;">Tambah Cabang</a>
        <div class="hidden md:block mx-auto text-slate-500">

        </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <form action="{{ route('cari_cabang') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="nama_pencarian" name="nama_pencarian" type="text"
                        class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Cabang...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Cari</button>
                    <a type="button" id="reset_pencarian" href="{{ route('cabang.index') }}"
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
    <div id="modal_cabang" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="cabangForm" action="{{ route('cabang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h2 class="text-lg font-medium mr-auto">Tambah Cabang</h2>
                        <button type="button" class="close" data-tw-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-10">
                        <div class="input-form mt-3">
                            <label for="nama_cabang" class="form-label w-full flex flex-col sm:flex-row">
                                Nama Cabang<span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                            </label>
                            <input id="nama_cabang" type="text" name="nama_cabang"
                                class="form-control @error('nama_cabang') border-danger @enderror" placeholder="Nama Cabang"
                                value="{{ old('nama_cabang') }}" minlength="2">
                            @error('nama_cabang')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-form mt-3">
                            <label for="deskripsi_cabang" class="form-label w-full flex flex-col sm:flex-row">
                                Deskripsi Cabang<span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                            </label>
                            <textarea id="deskripsi_cabang" type="text" name="deskripsi_cabang"
                                class="form-control @error('deskripsi_cabang') border-danger @enderror" placeholder="Deskripsi Cabang"
                                minlength="2">{{ old('deskripsi_cabang') }}</textarea>
                            @error('deskripsi_cabang')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-2" data-tw-dismiss="modal">Tutup</button>
                        <button type="submit" form="cabangForm" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($cabangs->isEmpty())
        <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
    @else
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            @php $no = 1; @endphp
            @foreach ($cabangs as $cabang)
                <div class="intro-y col-span-12 md:col-span-3">
                    <div class="box zoom-in">
                        <div class="flex flex-col lg:flex-row items-center p-5">
                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                <span class="font-medium">Cabang {{ $cabang->nama_cabang }}</span>
                                <div class="text-slate-500 text-xs mt-0.5">Deskripsi : {{ $cabang->deskripsi_cabang }}
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
                                                <a href="{{ url('cabang/' . $cabang->id . '/edit') }}"
                                                    class="dropdown-item">
                                                    <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit Cabang
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#hapus_modal" class="dropdown-item btn-hapus"
                                                    data-cabang-id="{{ $cabang->id }}">
                                                    <i data-lucide="trash" class="w-4 h-4 mr-2"></i> Hapus
                                                    Cabang
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
    @include('Cabang.modal')
    <script src="js/modal_hapus_cabang.js"></script>
    <script src="js/pencarian.js"></script>
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                $('#modal_cabang').modal('show');
            @endif
        });
    </script>
@endsection
