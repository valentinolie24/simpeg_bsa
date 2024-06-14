@extends('../layout/' . $layout)
@section('subhead')
    <title>Pegawai</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Pegawai</h2>
    </div>

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-5">
        @if (auth()->user()->role == 'sdm')
            <button id="btn_tambah" class="btn btn-primary" style="width: 150px; height: 40px;">Tambah
                User</button>
        @endif
        <div class="hidden md:block mx-auto text-slate-500">

        </div>

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            @if (auth()->user()->role == 'sdm')
                <form action="{{ route('cari') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <input id="nama_pencarian" name="nama_pencarian" type="text"
                            class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Pegawai...">
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button class="btn btn-primary shadow-md mr-2">Cari</button>
                        <a type="button" id="reset_pencarian" href="{{ route('pegawai.index') }}"
                            class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset</a>
                    </div>
                </form>
            @endif
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('success'))
                            <div class="alert alert-outline-success show flex items-center mb-2" role="alert">
                                <i data-lucide="user-check" class="w-6 h-6 mr-2"></i> {{ session()->get('success') }}
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
                        @if (session()->has('edit'))
                            <div class="alert alert-outline-success show flex items-center mb-2" role="alert">
                                <i data-lucide="edit-2" class="w-6 h-6 mr-2"></i> {{ session()->get('edit') }}
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
        </div>
    </div>
    @if (auth()->user()->role == 'sdm')
        @if ($pegawais->isEmpty())
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <div class="intro-y grid grid-cols-12 gap-6 mt-5">
                @foreach ($pegawais as $pegawai)
                    <div class="intro-y col-span-12 md:col-span-4">
                        <div class="box zoom-in">
                            <div class="flex flex-col lg:flex-row items-center p-5">
                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                    <img class="rounded-full" src="{{ asset('foto/' . $pegawai->foto) }}" alt="Foto Pegawai"
                                        data-action="zoom">
                                </div>
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#profil_modal_{{ $pegawai->id }}"
                                        class="font-medium">{{ $pegawai->nama }}</a>
                                    <div class="text-slate-500 text-xs mt-0.5">{{ $pegawai->jabatan }}</div>
                                    @if (is_null($pegawai->cabang_id))
                                        <div class="text-red-500 text-xs mt-1">
                                            Cabang belum ditentukan
                                        </div>
                                    @endif
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
                                                    <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#profil_modal_{{ $pegawai->id }}"
                                                        class="dropdown-item">
                                                        <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profil Pegawai
                                                    </a>
                                                </li>
                                                @if (auth()->user()->role == 'sdm')
                                                    <li>
                                                        <a href="{{ url('pegawai/' . $pegawai->id . '/edit') }}"
                                                            class="dropdown-item">
                                                            <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit Pegawai
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-tw-toggle="modal"
                                                            data-tw-target="#hapus_modal_{{ $pegawai->id }}"
                                                            class="dropdown-item btn-hapus"
                                                            data-pegawai-id="{{ $pegawai->id }}">
                                                            <i data-lucide="trash" class="w-4 h-4 mr-2"></i> Hapus Pegawai
                                                        </a>
                                                    </li>
                                                @endif
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
    @elseif (auth()->user()->role == 'pegawai')
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start ml-6">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none image-fit relative"
                        style="height: 150px; width: 150px;">
                        @if (isset($pegawai) && $pegawai->foto)
                            <img alt="Foto Pegawai" class="rounded-full" src="{{ asset('foto/' . $pegawai->foto) }}"
                                data-action="zoom">
                        @else
                            <img alt="Default Photo" class="rounded-full" src="{{ asset('dist/images/icon.png') }}">
                        @endif
                        {{-- <div
                            class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2">
                            <i class="w-4 h-4 text-white" data-lucide="camera"></i>
                        </div> --}}
                    </div>

                    <div class="ml-5">
                        <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                            {{ $pegawai->nama ?? 'Belum ada data' }}
                        </div>
                        <div class="text-slate-500">
                            {{ $pegawai->jabatan ?? 'Belum ada data' }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium font-bold text-center lg:text-left lg:mt-3">Informasi Pegawai</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        {{-- <div class="truncate sm:whitespace-normal flex items-center">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $pegawai->email ?? 'Belum ada info' }}
                        </div> --}}
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">NIK</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="user" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->nik ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Alamat</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="home" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->alamat ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Tempat Lahir</div>
                            <div id="tempat_lahir" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="home" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->tempat_lahir ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Tanggal Lahir</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->ttl ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Tanggal Masuk</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->tanggal_masuk ?? 'Belum ada info' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start ml-6">
                    {{-- <div class="font-medium text-center lg:text-left lg:mt-3">-</div> --}}
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        {{-- <div class="truncate sm:whitespace-normal flex items-center">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $pegawai->email ?? 'Belum ada info' }}
                        </div> --}}
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Pendidikan</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->pendidikan ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Status</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->status ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Agama</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="shield" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->agama ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Status Pekerjaan</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="briefcase" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->status_pekerjaan ?? 'Belum ada info' }}
                            </div>
                        </div>
                        <div class="flex flex-col mt-3">
                            <div class="font-bold text-slate-500">Cabang</div>
                            <div id="nik" class="flex items-center mt-1 whitespace-pre-wrap text-slate-500">
                                <i data-lucide="globe" class="w-4 h-4 text-slate-500 mr-2"></i>
                                {{ $pegawai->cabang->nama_cabang ?? 'Belum ada info' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle w-5 h-5 block mr-6" href="javascript:;" aria-expanded="false"
                        data-tw-toggle="dropdown">
                        <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                    </a>
                    <div class="dropdown-menu w-56">
                        <ul class="dropdown-content">
                            <li>
                                <h6 class="dropdown-header">Options</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                @if ($pegawai === null)
                                    <a href="{{ route('pegawai.create') }}" class="dropdown-item">
                                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Ubah Data
                                    </a>
                                @else
                                    @if (isset($pegawai->id) && $pegawai->id !== null)
                                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="dropdown-item">
                                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Ubah Data
                                        </a>
                                    @endif
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- HTML modal hapus --}}
    @include('Pegawai.modal')
    @include('Pegawai.modal_profil')
    {{-- javascript modal hapus --}}

    <script src="js/modal_hapus_pegawai.js"></script>
    {{-- <script src="js/modal_profil_pegawai.js"></script> --}}
    <script src="js/pencarian.js"></script>
@endsection


@section('script')
    <script>
        (function() {
            async function pegawai() {
                // Loading state
                $('#btn_tambah').html(
                    '<i data-loading-icon="tail-spin" data-color="white" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "{{ route('pegawai.create') }}";
            }

            $('#btn_tambah').on('click', function() {
                pegawai()
            })

        })()
    </script>
@endsection
