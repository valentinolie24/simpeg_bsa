@extends('../layout/' . $layout)
@section('subhead')
    <title>Promosi</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Promosi</h2>
    </div>

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-5">
        <button id="btn_tambah" class="btn btn-primary" style="width: 150px; height: 40px;">Tambah Promosi</button>
        <div class="hidden md:block mx-auto text-slate-500"></div>

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <form action="{{ route('cari') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="nama_pencarian" name="nama_pencarian" type="text"
                        class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Promosi...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Cari</button>
                    <a type="button" id="reset_pencarian" href="{{ route('promosi.index') }}"
                        class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset</a>
                </div>
            </form>
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
        @if ($promosi->isEmpty())
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">No</th>
                        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                        <th class="text-center whitespace-nowrap">Jabatan Lama</th>
                        <th class="text-center whitespace-nowrap">Jabatan Baru</th>
                        <th class="text-center whitespace-nowrap">Tanggal Promosi</th>
                        <th class="text-center whitespace-nowrap">Status Promosi</th>
                        <th class="text-center whitespace-nowrap">Aksi</th>
                        <th class="text-center whitespace-nowrap">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promosi as $index)
                        <tr class="intro-x" style="height: 100px">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $index->pegawai->nama }}</td>
                            <td class="text-center">{{ $index->jabatan_lama }}</td>
                            <td class="text-center">{{ $index->jabatan_baru }}</td>
                            <td class="text-center">{{ $index->tanggal_promosi->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $index->status_promosi }}</td>
                            <td class="text-center">
                                <a href="{{ route('promosi.edit', $index->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('promosi.destroy', $index->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                            <td class="text-center">{{ $index->catatan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
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
                window.location.href = "{{ route('promosi.create') }}";
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
