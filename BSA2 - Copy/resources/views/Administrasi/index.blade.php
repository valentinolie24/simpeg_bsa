@extends('../layout/' . $layout)
@section('subhead')
    <title>Administrasi</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Administrasi</h2>
    </div>
    <br>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <div class="intro-y col-span-12 md:col-span-4 overflow-auto lg:overflow-visible">
            <form action="{{ route('cari_administrasi') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="nama_pencarian" name="nama_pencarian" type="text"
                        class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Nama...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Cari</button>
                    <a type="button" id="reset_pencarian" href="{{ route('administrasi.index') }}"
                        class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset</a>
                </div>
            </form>

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
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('tolak'))
                            <div class="alert alert-outline-danger show flex items-center mb-2" role="alert">
                                <i data-lucide="x" class="w-6 h-6 mr-2"></i> {{ session()->get('tolak') }}
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

    <table class="table table-report mt-5">
        @if (!$daftars)
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <thead>
                <tr>
                    <th class="text-center whitespace-nowrap">No</th>
                    <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                    <th class="text-center whitespace-nowrap">Nama Pelamar</th>
                    <th class="text-center whitespace-nowrap">Waktu Daftar</th>
                    <th class="text-center whitespace-nowrap">CV</th>
                    <th class="text-center whitespace-nowrap">Surat Lamaran</th>
                    <th class="text-center whitespace-nowrap">Data Pendukung</th>
                    <th class="text-center whitespace-nowrap">Nomor WhatsApp</th>
                    <th class="text-center whitespace-nowrap">Status Administrasi</th>
                    @if (auth()->user()->role == 'sdm')
                        <th class="text-center whitespace-nowrap">Aksi</th>
                    @endif
                    <th class="text-center whitespace-nowrap">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftars as $index => $daftar)
                    <tr class="intro-x" style="height: 100px">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="table-report__action w-86 text-center">{{ $daftar->lowongan->posisi }}</td>
                        <td class="table-report__action w-86 font-medium whitespace-nowrap text-center">
                            {{ $daftar->user->name }}</td>
                        <td class="table-report__action w-86 text-center">
                            {{ $daftar->created_at->locale('id')->diffForHumans() }}
                        </td>
                        <td class="table-report__action w-86 text-center">
                            <a href="{{ asset('storage/daftar/' . $daftar->cv) }}"
                                class="btn btn-outline-dark cursor-pointer zoom-in btn-icon" target="_blank">
                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> <span class="ms-2">CV</span>
                            </a>
                        </td>

                        <td class="table-report__action w-56 text-center">
                            <a href="{{ asset('storage/daftar/' . $daftar->surat_lamaran) }}"
                                class="btn btn-outline-dark cursor-pointer zoom-in btn-icon" target="_blank">
                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> <span class="ms-2">Surat
                                    Lamaran</span>
                            </a>
                        </td>
                        <td class="table-report__action w-56 text-center">
                            @if ($daftar->data_pendukung)
                                <a href="{{ asset('storage/daftar/' . $daftar->data_pendukung) }}"
                                    class="btn btn-outline-dark cursor-pointer zoom-in btn-icon" target="_blank">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> <span class="ms-2">Data
                                        Pendukung</span>
                                </a>
                            @else
                                Tidak ada data pendukung
                            @endif
                        </td>
                        <td class="table-report__action w-48 text-center">
                            {{ $daftar->user->noWA }}
                        </td>


                        <td class="table-report__action w-48 text-center">
                            @if ($daftar->status_administrasi == '-')
                                <span class="text-warning">Menunggu</span>
                                <!-- Menampilkan status menunggu jika belum diambil tindakan -->
                            @else
                                @if ($daftar->status_administrasi == 'Diterima')
                                    <span class="text-success">Diterima</span>
                                @else
                                    <span class="text-danger">Ditolak</span>
                                @endif
                            @endif
                        </td>

                        @if (auth()->user()->role == 'sdm')
                            <td class="table-report__action w-56 item-center">
                                @if ($daftar->status_administrasi == '-')
                                    <div class="flex items-center">
                                        <form action="{{ route('administrasi.accept', $daftar->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="ml-4 mr-3 flex text-success cursor-pointer zoom-in"><i
                                                    data-lucide="check-square" class="w-4 h-4 mr-1"></i>Terima</button>
                                        </form>

                                        <form action="{{ route('administrasi.reject', $daftar->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_administrasi" value="berkas ditolak">
                                            <button type="submit" class="flex ml-3 text-danger cursor-pointer zoom-in"><i
                                                    data-lucide="x" class="w-4 h-4 mr-1"></i>Tolak</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        @endif
                        <td class="table-report__action w-86 text-center">
                            @if (auth()->user()->role == 'sdm')
                                @if ($daftar->count() > 0 && ($daftar->status_administrasi == 'Diterima' || $daftar->status_administrasi == 'Ditolak'))
                                    @if ($daftar->catatan)
                                        {{ $daftar->catatan }}
                                    @else
                                        <form action="{{ route('administrasi.saveNote', $daftar->id) }}" method="POST">
                                            @csrf
                                            <div class="flex items-center">
                                                <textarea id="catatan_{{ $daftar->id }}" name="catatan_{{ $daftar->id }}"
                                                    class="form-control @error('catatan_' . $daftar->id) border-danger @enderror" placeholder="Masukkan catatan"
                                                    rows="2"></textarea>
                                                <button type="submit" class="btn btn-primary ml-3">Simpan</button>
                                            </div>
                                            @error('catatan_' . $daftar->id)
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </form>
                                    @endif
                                @else
                                    <p class="text-center">Belum ada catatan</p>
                                @endif
                            @else
                                @if ($daftar->catatan)
                                    {{ $daftar->catatan }}
                                @else
                                    <p class="text-center">Belum ada catatan</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    @if (is_string($daftars))
        <div class="alert alert-warning" role="alert">
            {{ $daftars }}
        </div>
    @endif
    <script src="js/pencarian.js"></script>
@endsection
