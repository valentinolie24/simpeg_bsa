@extends('../layout/' . $layout)
@section('subhead')
    <title>Lowongan</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Lowongan</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @if (auth()->user()->role == 'sdm')
                <button id="btn_tambah" class="btn btn-primary" style="width: 150px; height: 40px;">Tambah
                    Lowongan</button>
                <div class="hidden md:block mx-auto text-slate-500">
                    {{-- Menampilkan {{ $pegawais->count() }} data pegawai --}}
                </div>
            @endif

            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="{{ route('cari_lowongan') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <input id="nama_pencarian" name="nama_pencarian" type="text"
                            class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Lowongan...">
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
    </div>
    @if ($lowongans->isEmpty())
        <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
    @else
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            @foreach ($lowongans as $lowongan)
                <div class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                        <div class="ml-3 mr-auto">
                            <a class="font-extrabold block font-medium text-base">{{ $lowongan->posisi }}</a>
                        </div>
                        <div class="dropdown ml-3">
                            @if (auth()->user()->role == 'sdm')
                                <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false"
                                    data-tw-toggle="dropdown">
                                    <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                </a>
                                <div class="dropdown-menu w-44">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="{{ url('lowongan/' . $lowongan->id . '/edit') }}"
                                                class="dropdown-item">
                                                <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit Lowongan
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#hapus_modal"
                                                class="dropdown-item btn-hapus" data-lowongan-id="{{ $lowongan->id }}">
                                                <i data-lucide="trash" class="w-4 h-4 mr-2"></i> Hapus Lowongan
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="h-40 2xl:h-56 image-fit" style="height: 500px">
                            <img alt="Foto Lowongan" class="rounded-md" src="{{ asset('foto/' . $lowongan->foto) }}"
                                data-action="zoom">
                        </div>
                        <a class="block font-medium text-base mt-5">{{ $lowongan->posisi }}</a>
                        <div class="text-slate-600 dark:text-slate-500 mt-2">{{ $lowongan->deskripsi }}
                        </div>
                    </div>
                    <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="intro-x flex mr-2">
                            <i data-lucide="tag" class="w-4 h-4 mt-0.5 mr-2"></i><span
                                class="mt-0.25">{{ $lowongan->gaji }}</span>
                        </div>
                    </div>
                    <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="ml-auto">Jumlah Lamaran : {{ $lowongan->daftar()->count() }}</div>
                    </div>
                    <input id="lowongan_id" type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                    <div class="px-5 pt-3 pb-5 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="w-full flex text-slate-500 text-xs sm:text-sm">
                            <div class="text-right mt-5">
                                @if (auth()->user()->role == 'calon_pegawai')
                                    <a type="sumbit" id="btn_daftar"
                                        class="btn btn-primary w-24
                                    mr-1">Daftar</a>
                                @endif
                            </div>
                            <div class="ml-auto"> Ditambahkan pada <span
                                    class="font-medium">{{ $lowongan->created_at->locale('id')->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @include('Lowongan.modal')

    <script src="js/pencarian.js"></script>
    <script src="js/modal_hapus_lowongan.js"></script>
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
                window.location.href = "{{ route('lowongan.create') }}";
            }

            $('#btn_tambah').on('click', function() {
                pegawai()
            })
            $('#btn_daftar').on('click', function() {
                // Mendapatkan id lowongan yang dipilih
                var lowongan_id = $(this).closest('.box').find('input[name="lowongan_id"]').val();
                // Arahkan pengguna ke halaman formulir pendaftaran dengan ID lowongan
                window.location.href = "{{ route('daftar.index') }}?lowongan_id=" + lowongan_id;
            })
        })()
    </script>
@endsection
