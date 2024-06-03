@extends('../layout/' . $layout)
@section('subhead')
    <title>Tes</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Tes</h2>
    </div>
    <br>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

        <div class="intro-y col-span-12 md:col-span-4 overflow-auto lg:overflow-visible">
            <form action="{{ route('cari_tes') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="nama_pencarian" name="nama_pencarian" type="text"
                        class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Nama...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Cari</button>
                    <a type="button" id="reset_pencarian" href="{{ route('tes.index') }}"
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
                        @if (session()->has('error'))
                            <div class="alert alert-outline-danger show flex items-center mb-2" role="alert">
                                <i data-lucide="x" class="w-6 h-6 mr-2"></i> {{ session()->get('error') }}
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
        @if ($calon_pegawai->isEmpty())
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <div class="intro-y pr-1">
                <div class="box p-2">
                    <ul class="nav nav-pills" role="tablist">
                        <td class="nav-item flex-1" style="visibility: hidden;"></td>
                        <li id="calon_pegawai" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                data-tw-target="#calon_pegawai" type="button" role="tab" aria-controls="calon_pegawai"
                                aria-selected="true">
                                Calon Pegawai
                            </button>
                        </li>
                        <li id="tes_tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#tes" type="button"
                                role="tab" aria-controls="tes" aria-selected="false">
                                Tes
                            </button>
                        </li>
                        <td class="nav-item flex-1" style="visibility: hidden;"></td>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="calon_pegawai" class="tab-pane active" role="tabpanel" aria-labelledby="calon_pegawai">

                    <table class="table table-report mt-5">
                        <thead>
                            <tr>
                                <th class="text-center whitespace-nowrap">No</th>
                                <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                                <th class="text-center whitespace-nowrap">Nama Pelamar</th>
                                <th class="text-center whitespace-nowrap">Tes</th>
                                <th class="text-center whitespace-nowrap">Status Tes</th>
                                <th class="text-center whitespace-nowrap">Aksi</th>
                                <th class="text-center whitespace-nowrap">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($calon_pegawai as $pegawai)
                                @if ($pegawai)
                                    <tr class="intro-x" style="height: 250px">
                                        <td class="text-center" style="width: 70px;">{{ $no++ }}</td>
                                        <td class="table-report__action text-center" style="width: 200px;">
                                            {{ $pegawai->daftar && $pegawai->daftar->lowongan ? $pegawai->daftar->lowongan->posisi : '-' }}
                                        </td>
                                        <td class="table-report__action font-medium whitespace-nowrap text-center"
                                            style="width: 250px;">
                                            {{ $pegawai->name }}
                                        </td>
                                        <td class="table-report__action">
                                            <form action="{{ route('tes.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $pegawai->id }}">
                                                <div class="input-form mt-3">
                                                    <label for="jenis_tes"
                                                        class="form-label w-full flex flex-col sm:flex-row">
                                                        Jenis Tes <span
                                                            class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                                    </label>
                                                    <select id="jenis_tes_{{ $pegawai->id }}" name="jenis_tes"
                                                        class="form-select mt-1 sm:mr-2 form-control @error('jenis_tes') border-danger @enderror"
                                                        aria-label="Default select example"
                                                        onchange="toggleNilaiTes({{ $pegawai->id }})">
                                                        <option selected disabled hidden value="">Pilih Jenis
                                                            Tes
                                                        </option>
                                                        <option value="Tes Tertulis"
                                                            {{ old('jenis_tes') == 'Tes Tertulis' ? 'selected' : '' }}>
                                                            Tes Tertulis</option>
                                                        <option value="Tes Komputer"
                                                            {{ old('jenis_tes') == 'Tes Komputer' ? 'selected' : '' }}>
                                                            Tes Komputer</option>
                                                        <option value="Tes Speaking"
                                                            {{ old('jenis_tes') == 'Tes Speaking' ? 'selected' : '' }}>
                                                            Tes Speaking</option>
                                                        <option value="Tes Wawancara"
                                                            {{ old('jenis_tes') == 'Tes Wawancara' ? 'selected' : '' }}>
                                                            Tes Wawancara</option>
                                                    </select>
                                                    @error('jenis_tes')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div id="nilai_tes_tertulis_{{ $pegawai->id }}" class="input-form mt-3"
                                                    style="display: none;">
                                                    <label for="nilai_tes_tertulis_input_{{ $pegawai->id }}"
                                                        class="form-label w-full flex flex-col sm:flex-row">
                                                        Nilai Tes <span
                                                            class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                                    </label>
                                                    <input type="number" name="nilai_tes"
                                                        id="nilai_tes_tertulis_input_{{ $pegawai->id }}" min="1"
                                                        max="100"
                                                        class="mt-1 form-control @error('nilai_tes') border-danger @enderror"
                                                        value="{{ old('nilai_tes') }}">
                                                    @error('nilai_tes')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div id="nilai_tes_lain_{{ $pegawai->id }}" class="input-form mt-3"
                                                    style="display: none;">
                                                    <label for="nilai_tes_lain_select_{{ $pegawai->id }}"
                                                        class="form-label w-full flex flex-col sm:flex-row">
                                                        Nilai Tes <span
                                                            class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                                    </label>
                                                    <select name="nilai_tes"
                                                        id="nilai_tes_lain_select_{{ $pegawai->id }}"
                                                        class="form-select mt-1 sm:mr-2 form-control @error('nilai_tes') border-danger @enderror">
                                                        <option selected disabled hidden value="">Pilih Nilai
                                                        </option>
                                                        <option value="Kurang"
                                                            {{ old('nilai_tes') == 'Kurang' ? 'selected' : '' }}>
                                                            Kurang
                                                        </option>
                                                        <option value="Cukup"
                                                            {{ old('nilai_tes') == 'Cukup' ? 'selected' : '' }}>
                                                            Cukup
                                                        </option>
                                                        <option value="Cukup Baik"
                                                            {{ old('nilai_tes') == 'Cukup Baik' ? 'selected' : '' }}>
                                                            Cukup Baik</option>
                                                        <option value="Baik"
                                                            {{ old('nilai_tes') == 'Baik' ? 'selected' : '' }}>Baik
                                                        </option>
                                                        <option value="Sangat Baik"
                                                            {{ old('nilai_tes') == 'Sangat Baik' ? 'selected' : '' }}>
                                                            Sangat Baik</option>
                                                    </select>
                                                    @error('nilai_tes')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="text-right mt-5">
                                                    <button id="btn_save" class="btn btn-primary" type="submit">Tambah
                                                        Tes</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="table-report__action text-center" style="width: 250px;">
                                            @php
                                                $status_tes = '-';
                                                foreach ($pegawai->tes as $tes) {
                                                    if ($tes->status_tes == 'Diterima') {
                                                        $status_tes = 'Diterima';
                                                        break; // Jika salah satu tes diterima, hentikan loop
                                                    } elseif ($tes->status_tes == 'Ditolak') {
                                                        $status_tes = 'Ditolak';
                                                        break; // Jika salah satu tes ditolak, hentikan loop
                                                    }
                                                }
                                            @endphp
                                            @if ($status_tes == 'Diterima')
                                                <span class="text-success">Diterima</span>
                                            @elseif ($status_tes == 'Ditolak')
                                                <span class="text-danger">Ditolak</span>
                                            @else
                                                <span class="text-warning">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="table-report__action font-medium whitespace-nowrap text-center"
                                            style="width: 250px;">
                                            @if ($status_tes == '-' || $pegawai->tes->isEmpty())
                                                <div class="flex items-center">
                                                    <form action="{{ route('tes.accept', $pegawai->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="user_id"
                                                            value="{{ $pegawai->id }}">
                                                        <!-- Tambahkan input user_id -->
                                                        <input type="hidden" name="status_tes" value="Diterima">
                                                        <!-- Tambahkan input status_tes -->
                                                        <button type="submit"
                                                            class="ml-4 mr-3 flex text-success cursor-pointer zoom-in">
                                                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Terima
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('tes.reject', $pegawai->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="user_id"
                                                            value="{{ $pegawai->id }}">
                                                        <!-- Tambahkan input user_id -->
                                                        <input type="hidden" name="status_tes" value="Ditolak">
                                                        <!-- Tambahkan input status_tes -->
                                                        <button type="submit"
                                                            class="flex ml-3 text-danger cursor-pointer zoom-in">
                                                            <i data-lucide="x" class="w-4 h-4 mr-1"></i>Tolak
                                                        </button>
                                                    </form>

                                                </div>
                                            @endif
                                        </td>
                                        <td class="table-report__action w-86 text-center">
                                            @if (auth()->user()->role == 'sdm')
                                                @php
                                                    $hasAcceptedOrRejected = false;
                                                @endphp

                                                @foreach ($pegawai->tes as $tes)
                                                    @if ($tes->status_tes == 'Diterima' || $tes->status_tes == 'Ditolak')
                                                        @php
                                                            $hasAcceptedOrRejected = true;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if ($hasAcceptedOrRejected)
                                                    @php
                                                        $catatan = $pegawai->tes->firstWhere('catatan', '!=', null);
                                                    @endphp

                                                    @if ($catatan)
                                                        {{ $catatan->catatan }}
                                                    @else
                                                        <form action="{{ route('tes.saveNote', ['id' => $tes->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="flex items-center">
                                                                <textarea id="catatan" name="catatan" class="form-control @error('catatan') border-danger @enderror"
                                                                    placeholder="Masukkan catatan" rows="2"></textarea>
                                                                <button type="submit"
                                                                    class="btn btn-primary ml-3">Simpan</button>
                                                            </div>
                                                            @error('catatan')
                                                                <div class="text-danger mt-1">{{ $message }}</div>
                                                            @enderror
                                                        </form>
                                                    @endif
                                                @else
                                                    <p class="text-center">Belum ada catatan</p>
                                                @endif
                                            @else
                                                <p class="text-center">Belum ada catatan</p>
                                            @endif
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="tes" class="tab-pane" role="tabpanel" aria-labelledby="tes_tab">
                    <div class="overflow-x-auto">
                        <table class="table table-report mt-5 mb-5" style="height: 300px">
                            <thead class="mt-5">
                                <tr>
                                    <th class="text-center whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                                    <th class="text-center whitespace-nowrap">Nama Pelamar</th>
                                    <th class="text-center whitespace-nowrap">Tes</th>
                                    <th class="text-center whitespace-nowrap">Status Tes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($calon_pegawai as $pegawai)
                                    <tr class="intro-x">
                                        <td class="text-center" style="width: 70px;">{{ $no++ }}</td>
                                        <td class="table-report__action w-86 text-center" style="width: 250px;">
                                            {{ $pegawai->daftar && $pegawai->daftar->lowongan ? $pegawai->daftar->lowongan->posisi : '-' }}
                                        </td>
                                        <td class="table-report__action font-medium w-86 text-center"
                                            style="width: 250px;">
                                            {{ $pegawai->name }}</td>
                                        <td class="table-report__action w-86 text-center">
                                            <div class="">
                                                @if ($pegawai->tes)
                                                    <div class="box p-2 mr-4 ml-4 mt-2 mb-2">
                                                        @foreach ($pegawai->tes as $index => $tes)
                                                            <a
                                                                class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                                                                <div class="max-w-[50%] truncate mr-1">
                                                                    {{ $tes->jenis_tes }}</div>
                                                                <div class="ml-auto font-medium mb-2">
                                                                    {{ $tes->nilai_tes }}</div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-center">Belum ada data tes</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="table-report__action font-medium whitespace-nowrap text-center"
                                            style="width: 250px;">
                                            @php
                                                $status_tes = '-';
                                                foreach ($pegawai->tes as $tes) {
                                                    if ($tes->status_tes == 'Diterima') {
                                                        $status_tes = 'Diterima';
                                                        break; // Jika salah satu tes diterima, hentikan loop
                                                    } elseif ($tes->status_tes == 'Ditolak') {
                                                        $status_tes = 'Ditolak';
                                                        break; // Jika salah satu tes ditolak, hentikan loop
                                                    }
                                                }
                                            @endphp
                                            @if ($status_tes == 'Diterima')
                                                <span class="text-success">Diterima</span>
                                            @elseif ($status_tes == 'Ditolak')
                                                <span class="text-danger">Ditolak</span>
                                            @else
                                                <span class="text-warning">Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endif
    @else
        @if ($calon_pegawai)
            <div class="overflow-x-auto">
                <table class="table table-report mt-5 mb-5" style="height: 150px">
                    <thead class="mt-5">
                        <tr>
                            <th class="text-center whitespace-nowrap">No</th>
                            <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                            <th class="text-center whitespace-nowrap">Nama Pelamar</th>
                            <th class="text-center whitespace-nowrap">Tes</th>
                            <th class="text-center whitespace-nowrap">Status Tes</th>
                            <th class="text-center whitespace-nowrap">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="intro-x">
                            <td class="text-center" style="width: 70px;">1</td>
                            <td class="table-report__action w-86 text-center" style="width: 250px;">
                                {{ $calon_pegawai->daftar && $calon_pegawai->daftar->lowongan ? $calon_pegawai->daftar->lowongan->posisi : '-' }}
                            </td>
                            <td class="table-report__action font-medium w-86 text-center" style="width: 250px;">
                                {{ $calon_pegawai->name }}</td>
                            <td class="table-report__action w-86 text-center">
                                <div class="">
                                    @if ($calon_pegawai->tes->isNotEmpty())
                                        <div class="box p-2 mr-4 ml-4 mt-2 mb-2">
                                            @foreach ($calon_pegawai->tes as $tes)
                                                <a
                                                    class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                                                    <div class="max-w-[50%] truncate mr-1">
                                                        {{ $tes->jenis_tes }}</div>
                                                    <div class="ml-auto font-medium mb-2">
                                                        {{ $tes->nilai_tes }}</div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-center">Belum ada data tes</p>
                                    @endif
                                </div>
                            </td>
                            <td class="table-report__action font-medium whitespace-nowrap text-center"
                                style="width: 250px;">
                                @php
                                    $status_tes = '-';
                                    foreach ($calon_pegawai->tes as $tes) {
                                        if ($tes->status_tes == 'Diterima') {
                                            $status_tes = 'Diterima';
                                            break; // Jika salah satu tes diterima, hentikan loop
                                        } elseif ($tes->status_tes == 'Ditolak') {
                                            $status_tes = 'Ditolak';
                                            break; // Jika salah satu tes ditolak, hentikan loop
                                        }
                                    }
                                @endphp
                                @if ($status_tes == 'Diterima')
                                    <span class="text-success">Diterima</span>
                                @elseif ($status_tes == 'Ditolak')
                                    <span class="text-danger">Ditolak</span>
                                @else
                                    <span class="text-warning">Menunggu</span>
                                @endif
                            </td>
                            <td class="table-report__action w-56 text-center">
                                @if ($calon_pegawai->tes->isNotEmpty())
                                    @foreach ($calon_pegawai->tes as $tes)
                                        @if ($tes->catatan)
                                            {{ $tes->catatan }}
                                        @else
                                            <p class="text-center">Belum ada catatan</p>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-center">Belum ada catatan</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @endif
    @endif
    </div>
@endsection
<script src="js/pencarian.js"></script>
<script>
    function toggleNilaiTes(pegawaiId) {
        var jenisTes = document.getElementById('jenis_tes_' + pegawaiId).value;
        var nilaiTesTertulis = document.getElementById('nilai_tes_tertulis_' + pegawaiId);
        var nilaiTesLain = document.getElementById('nilai_tes_lain_' + pegawaiId);

        if (jenisTes === 'Tes Tertulis') {
            nilaiTesTertulis.style.display = 'block';
            nilaiTesLain.style.display = 'none';
        } else {
            nilaiTesTertulis.style.display = 'none';
            nilaiTesLain.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^="jenis_tes_"]').forEach(function(element) {
            element.addEventListener('change', function() {
                toggleNilaiTes(element.id.split('_')[2]);
            });
        });
    });
</script>
