@extends('../layout/' . $layout)
@section('subhead')
    <title>Demosi</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Demosi</h2>
    </div>

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-5">
        @if (auth()->user()->role == 'sdm')
            <button id="btn_tambah" class="btn btn-primary" style="width: 150px; height: 40px;">Tambah Demosi</button>
        @endif
        <div class="hidden md:block mx-auto text-slate-500"></div>

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            @if (auth()->user()->role == 'sdm')
                <form action="{{ route('cari_demosi') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <input id="nama_pencarian" name="nama_pencarian" type="text"
                            class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Demosi...">
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button class="btn btn-primary shadow-md mr-2">Cari</button>
                        <a type="button" id="reset_pencarian" href="{{ route('demosi.index') }}"
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
        @if ($demosi->isEmpty())
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <table class="table table-report mt-5">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">No</th>
                        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                        <th class="text-center whitespace-nowrap">Jabatan Lama</th>
                        <th class="text-center whitespace-nowrap">Jabatan Baru</th>
                        <th class="text-center whitespace-nowrap">Tanggal Demosi</th>
                        <th class="text-center whitespace-nowrap">Status Demosi</th>
                        <th class="text-center whitespace-nowrap">Aksi</th>
                        <th class="text-center whitespace-nowrap">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demosi as $index)
                        <tr class="intro-x" style="height: 100px">
                            <td class="text-center" style="width: 80px;">{{ $loop->iteration }}</td>
                            <td class="table-report__action font-medium text-center" style="width: 250px;">
                                {{ $index->pegawai->nama }}</td>
                            <td class="table-report__action text-center" style="width: 250px;">{{ $index->jabatan_lama }}
                            </td>
                            <td class="table-report__action text-center" style="width: 250px;">{{ $index->jabatan_baru }}
                            </td>
                            <td class="table-report__action text-center" style="width: 250px;">
                                {{ \Carbon\Carbon::parse($index->tanggal_demosi)->translatedFormat('d F Y') }}
                            </td>
                            </td>
                            <td class="table-report__action text-center" style="width: 250px;">
                                @if ($index->status_demosi)
                                    @if ($index->status_demosi == 'Diterima')
                                        <span class="text-success">Diterima</span>
                                    @elseif ($index->status_demosi == 'Ditolak')
                                        <span class="text-danger">Ditolak</span>
                                    @else
                                        <span class="text-warning">Menunggu</span>
                                    @endif
                                @else
                                    <span class="text-warning">Menunggu</span>
                                @endif
                            </td>
                            <td class="table-report__action font-medium whitespace-nowrap text-center"
                                style="width: 300px;">
                                @if ($index->status_demosi == '-')
                                    <div class="flex items-center">
                                        <form action="{{ route('demosi.accept', $index->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="user_id" value="{{ $index->id }}">
                                            <input type="hidden" name="status_demosi" value="Diterima">
                                            <button type="submit"
                                                class="ml-5 mr-3 mt-5 flex text-success cursor-pointer zoom-in">
                                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('demosi.reject', $index->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="user_id" value="{{ $index->id }}">
                                            <input type="hidden" name="status_demosi" value="Ditolak">
                                            <button type="submit"
                                                class="flex ml-6 mr-3 mt-5 text-danger cursor-pointer zoom-in">
                                                <i data-lucide="x" class="w-4 h-4 mr-1"></i>Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td class="table-report__action w-86 text-center">
                                @if ($index->status_demosi == 'Diterima' || $index->status_demosi == 'Ditolak')
                                    @if ($index->catatan)
                                        <span>
                                            {{ $index->catatan }}
                                        </span>
                                    @else
                                        <form action="{{ route('demosi.saveNote', $index->id) }}" method="POST">
                                            @csrf
                                            <div class="flex items-center">
                                                <textarea id="catatan_{{ $index->id }}" name="catatan_{{ $index->id }}"
                                                    class="form-control @error('catatan_' . $index->id) border-danger @enderror" placeholder="Masukkan catatan"
                                                    rows="2"></textarea>
                                                <button type="submit" class="btn btn-primary ml-3">Simpan</button>
                                            </div>
                                            @error('catatan_' . $index->id)
                                                <div class="text-danger ml-3 mt-1">{{ $message }}</div>
                                            @enderror
                                        </form>
                                    @endif
                                @else
                                    <p class="text-center">Belum ada catatan</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        @if ($demosi->isEmpty())
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <table class="table table-report mt-5">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">No</th>
                        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                        <th class="text-center whitespace-nowrap">Jabatan Lama</th>
                        <th class="text-center whitespace-nowrap">Jabatan Baru</th>
                        <th class="text-center whitespace-nowrap">Tanggal Demosi</th>
                        <th class="text-center whitespace-nowrap">Status Demosi</th>
                        <th class="text-center whitespace-nowrap">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demosi as $index)
                        <tr class="intro-x" style="height: 100px">
                            <td class="text-center" style="width: 80px;">{{ $loop->iteration }}</td>
                            <td class="table-report__action font-medium text-center" style="width: 250px;">
                                {{ $index->pegawai->nama }}</td>
                            <td class="table-report__action text-center" style="width: 250px;">{{ $index->jabatan_lama }}
                            </td>
                            <td class="table-report__action text-center" style="width: 250px;">{{ $index->jabatan_baru }}
                            </td>
                            <td class="table-report__action text-center" style="width: 250px;">
                                {{ $index->tanggal_demosi }}
                            </td>
                            <td class="table-report__action text-center" style="width: 250px;">
                                @if ($index->status_demosi)
                                    @if ($index->status_demosi == 'Diterima')
                                        <span class="text-success">Diterima</span>
                                    @elseif ($index->status_demosi == 'Ditolak')
                                        <span class="text-danger">Ditolak</span>
                                    @else
                                        <span class="text-warning">Menunggu</span>
                                    @endif
                                @else
                                    <span class="text-warning">Menunggu</span>
                                @endif
                            </td>
                            <td class="table-report__action w-86 text-center">
                                @if ($index->catatan)
                                    <span>
                                        {{ $index->catatan }}
                                    </span>
                                @else
                                    <p class="text-center">Belum ada catatan</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    <script src="js/pencarian.js"></script>
@endsection

@section('script')
    <script>
        (function() {
            async function pegawai() {
                $('#btn_tambah').html(
                    '<i data-loading-icon="tail-spin" data-color="white" class="w-5 h-5 mx-auto"></i>');
                tailwind.svgLoader();
                await helper.delay(1500);
                window.location.href = "{{ route('demosi.create') }}";
            }

            $('#btn_tambah').on('click', function() {
                pegawai();
            });

            const pegawaiSelect = document.getElementById('pegawai_id');
            const jabatanLamaInput = document.getElementById('jabatan_lama');
            const jabatanBaruSelect = document.getElementById('jabatan_baru');

            pegawaiSelect.addEventListener('change', function() {
                const pegawaiId = this.value;

                if (pegawaiId) {
                    fetch(`/pegawai/${pegawaiId}`)
                        .then(response => response.json())
                        .then(data => {
                            jabatanLamaInput.value = data.jabatan;
                            jabatanLamaInput.disabled = false; // Enable jabatan lama input

                            // Update Jabatan Baru Options
                            const jabatanBaruOptions = jabatanBaruSelect.querySelectorAll('option');
                            jabatanBaruOptions.forEach(option => {
                                option.disabled = false; // Reset all options
                                if (option.textContent === data.jabatan) {
                                    option.disabled = true;
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching pegawai data:', error));
                } else {
                    jabatanLamaInput.value = '';
                    jabatanLamaInput.disabled = true; // Disable jabatan lama input

                    // Reset Jabatan Baru Options
                    const jabatanBaruOptions = jabatanBaruSelect.querySelectorAll('option');
                    jabatanBaruOptions.forEach(option => {
                        option.disabled = false;
                    });
                }
            });

            jabatanBaruSelect.addEventListener('change', function() {
                jabatanLamaInput.disabled = true;
                jabatanLamaInput.value = '';
            });

            // Additional logic to disable jabatan baru options that match jabatan lama
            const pegawaiSelectElem = document.getElementById('pegawai_id');
            pegawaiSelectElem.addEventListener('change', function() {
                const pegawaiId = this.value;

                if (pegawaiId) {
                    fetch(`/pegawai/${pegawaiId}`)
                        .then(response => response.json())
                        .then(data => {
                            const jabatanLama = data.jabatan;
                            const jabatanBaruOptions = jabatanBaruSelect.querySelectorAll('option');

                            jabatanBaruOptions.forEach(option => {
                                if (option.textContent.trim() === jabatanLama) {
                                    option.disabled = true;
                                } else {
                                    option.disabled = false;
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching pegawai data:', error));
                }
            });
        })();
    </script>
@endsection
