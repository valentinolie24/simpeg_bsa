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
                Pegawai</button>
            <div class="hidden md:block mx-auto text-slate-500">

            </div>
        @endif

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
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
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('info'))
                            <div class="alert alert-outline-success show flex items-center mb-2" role="alert">
                                <i data-lucide="user-check" class="w-6 h-6 mr-2"></i> {{ session()->get('info') }}
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
    @if ($pegawais->isEmpty())
        <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
    @else
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            @foreach ($pegawais as $pegawai)
                <div class="intro-y col-span-12 md:col-span-4">
                    <div class="box zoom-in">
                        <div class="flex flex-col lg:flex-row items-center p-5">
                            <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                <img class="rounded-full" src="{{ asset('foto/' . $pegawai->foto) }}" alt="Foto Pegawai">
                            </div>
                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                <a href="javascript:;" data-tw-toggle="modal"
                                    data-tw-target="#profil_modal_{{ $pegawai->id }}"
                                    class="font-medium">{{ $pegawai->nama }}</a>
                                <div class="text-slate-500 text-xs mt-0.5">{{ $pegawai->jabatan }}</div>
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
                                                        data-tw-target="#hapus_modal" class="dropdown-item btn-hapus"
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
