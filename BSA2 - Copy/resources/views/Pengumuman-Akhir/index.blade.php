@extends('../layout/' . $layout)
@section('subhead')
    <title>Pengumuman Akhir</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Pengumuman Akhir</h2>
    </div>
    <br>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <div class="intro-y col-span-12 md:col-span-4 overflow-auto lg:overflow-visible">
            <form action="{{ route('cari_pengumuman_akhir') }}" method="get" id="form_pencarian" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="nama_pencarian" name="nama_pencarian" type="text"
                        class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Nama...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Cari</button>
                    <a type="button" id="reset_pencarian" href="{{ route('pengumuman-akhir.index') }}"
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
            <table class="table table-report mt-5">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">No</th>
                        <th class="text-center whitespace-nowrap">Nama</th>
                        <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                        <th class="text-center whitespace-nowrap">No WA</th>
                        <th class="text-center whitespace-nowrap">Email</th>
                        {{-- <th class="text-center whitespace-nowrap">Status Administrasi</th>
                        <th class="text-center whitespace-nowrap">Status Tes</th> --}}
                        <th class="text-center whitespace-nowrap">Status Akhir</th>
                        <th class="text-center whitespace-nowrap">Aksi</th>
                        <th class="text-center whitespace-nowrap">Catatan</th>
                        <th class="text-center whitespace-nowrap">Tanggal Masuk Kerja</th>
                        <th class="text-center whitespace-nowrap">Countdown Kerja</th>

                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($calon_pegawai as $pegawai)
                        <tr class="intro-x" style="height: 250px">
                            <td class="text-center" style="width: 70px;">{{ $no++ }}</td>
                            <td class="table-report__action font-medium text-center" style="width: 200px;">
                                {{ $pegawai->name }}</td>
                            <td class="table-report__action text-center" style="width: 200px;">
                                {{ $pegawai->daftar && $pegawai->daftar->lowongan ? $pegawai->daftar->lowongan->posisi : '-' }}
                            </td>
                            <td class="table-report__action text-center" style="width: 200px;">{{ $pegawai->noWA }}</td>
                            <td class="table-report__action text-center" style="width: 200px;">{{ $pegawai->email }}</td>
                            {{-- <td class="table-report__action text-center text-success" style="width: 200px;">
                                {{ $pegawai->daftar->where('status_administrasi', 'Diterima')->first()->status_administrasi }}
                            </td>
                            <td class="table-report__action text-center text-success" style="width: 200px;">
                                {{ $pegawai->tes->where('status_tes', 'Diterima')->first()->status_tes }}
                            </td> --}}
                            <td class="table-report__action text-center" style="width: 200px;">
                                @if ($pegawai->pengumuman_akhir)
                                    @if ($pegawai->pengumuman_akhir->status_akhir == 'Diterima')
                                        <span class="text-success">Diterima</span>
                                    @elseif ($pegawai->pengumuman_akhir->status_akhir == 'Ditolak')
                                        <span class="text-danger">Ditolak</span>
                                    @else
                                        <span class="text-warning">Menunggu</span>
                                    @endif
                                @else
                                    <span class="text-warning">Menunggu</span>
                                @endif
                            </td>
                            <td class="table-report__action font-medium whitespace-nowrap text-center"
                                style="width: 250px;">
                                @if ($pegawai->pengumuman_akhir === null || $pegawai->pengumuman_akhir->count() == 0)
                                    <div class="flex items-center">
                                        <form action="{{ route('pengumuman-akhir.accept', $pegawai->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="user_id" value="{{ $pegawai->id }}">
                                            <!-- Tambahkan input user_id -->
                                            <input type="hidden" name="status_akhir" value="Diterima">
                                            <!-- Tambahkan input status_tes -->
                                            <button type="submit"
                                                class="ml-5 mr-3 mt-5 flex text-success cursor-pointer zoom-in">
                                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('pengumuman-akhir.reject', $pegawai->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="user_id" value="{{ $pegawai->id }}">
                                            <!-- Tambahkan input user_id -->
                                            <input type="hidden" name="status_akhir" value="Ditolak">
                                            <!-- Tambahkan input status_tes -->
                                            <button type="submit"
                                                class="flex ml-6 mr-3 mt-5 text-danger cursor-pointer zoom-in">
                                                <i data-lucide="x" class="w-4 h-4 mr-1"></i>Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td class="table-report__action w-86 text-center" style="width: 400px;">
                                @if (auth()->user()->role == 'sdm')
                                    @if (
                                        $pegawai->pengumuman_akhir &&
                                            ($pegawai->pengumuman_akhir->status_akhir == 'Diterima' ||
                                                $pegawai->pengumuman_akhir->status_akhir == 'Ditolak'))
                                        @if ($pegawai->pengumuman_akhir->catatan)
                                            <span
                                                class="{{ $pegawai->pengumuman_akhir->status_akhir == 'Diterima' ? 'text-success' : 'text-danger' }}">
                                                {{ $pegawai->pengumuman_akhir->catatan }}
                                            </span>
                                        @else
                                            <form
                                                action="{{ route('pengumuman-akhir.saveNote', $pegawai->pengumuman_akhir->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="flex items-center">
                                                    <textarea name="catatan" class="form-control" placeholder="Masukkan catatan" rows="2"></textarea>
                                                    <button type="submit" class="btn btn-primary ml-3">Simpan</button>
                                                </div>
                                            </form>
                                        @endif
                                    @else
                                        <p class="text-center">Belum ada catatan</p>
                                    @endif
                                @else
                                    @if ($pegawai->pengumuman_akhir && $pegawai->pengumuman_akhir->catatan)
                                        <span
                                            class="{{ $pegawai->pengumuman_akhir->status_akhir == 'Diterima' ? 'text-success' : 'text-danger' }}">
                                            {{ $pegawai->pengumuman_akhir->catatan }}
                                        </span>
                                    @else
                                        <p class="text-center">Belum ada catatan</p>
                                    @endif
                                @endif
                            </td>
                            <td class="table-report__action w-86 text-center" style="width: 200px;">
                                @if ($pegawai->pengumuman_akhir && $pegawai->pengumuman_akhir->catatan)
                                    @if ($pegawai->pengumuman_akhir->status_akhir == 'Diterima')
                                        @if ($pegawai->pengumuman_akhir->tanggal_masuk)
                                            <span>{{ \Carbon\Carbon::parse($pegawai->pengumuman_akhir->tanggal_masuk)->format('d-m-Y H:i') }}</span>
                                        @else
                                            <form
                                                action="{{ route('pengumuman-akhir.updateTanggalMasuk', $pegawai->pengumuman_akhir->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="flex items-center">
                                                    <input type="datetime-local" name="tanggal_masuk"
                                                        class="form-control" id="tanggalMasuk" required>
                                                    <button type="submit" class="btn btn-primary ml-3">Simpan</button>
                                                </div>
                                            </form>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var tanggalMasukInput = document.getElementById('tanggalMasuk');
                                                    var now = new Date();
                                                    var year = now.getFullYear();
                                                    var month = ('0' + (now.getMonth() + 1)).slice(-2);
                                                    var day = ('0' + now.getDate()).slice(-2);
                                                    var hour = ('0' + now.getHours()).slice(-2);
                                                    var minute = ('0' + now.getMinutes()).slice(-2);
                                                    var currentDate = year + '-' + month + '-' + day;
                                                    var currentTime = hour + ':' + minute;
                                                    var minDateTime = currentDate + 'T' + currentTime;

                                                    tanggalMasukInput.min = minDateTime;

                                                    tanggalMasukInput.addEventListener('change', function() {
                                                        var selectedDate = new Date(tanggalMasukInput.value);
                                                        var selectedDateStr = selectedDate.toISOString().slice(0, 10);
                                                        if (selectedDateStr === currentDate) {
                                                            tanggalMasukInput.min = minDateTime;
                                                        } else {
                                                            tanggalMasukInput.min = currentDate + 'T00:00';
                                                        }
                                                    });
                                                });
                                            </script>
                                        @endif
                                    @elseif ($pegawai->pengumuman_akhir->status_akhir == 'Ditolak')
                                        <p class="text-center">Pegawai tidak diterima kerja</p>
                                    @endif
                                @else
                                    <p class="text-center">Catatan harus diisi terlebih dahulu</p>
                                @endif
                            </td>
                            <td class="table-report__action w-86 text-center" style="width: 200px;">
                                @if ($pegawai->pengumuman_akhir && $pegawai->pengumuman_akhir->catatan)
                                    @if ($pegawai->pengumuman_akhir->status_akhir == 'Diterima')
                                        @if ($pegawai->pengumuman_akhir->tanggal_masuk)
                                            <span id="message-{{ $pegawai->id }}">Kamu harus datang ke kantor
                                                dalam</span>
                                            <span id="countdown-{{ $pegawai->id }}"></span>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var countdownElement = document.getElementById('countdown-{{ $pegawai->id }}');
                                                    var messageElement = document.getElementById('message-{{ $pegawai->id }}');
                                                    var targetDate = new Date('{{ $pegawai->pengumuman_akhir->tanggal_masuk }}').getTime();
                                                    var roleUpdated = false; // Deklarasi flag di sini

                                                    var now = new Date().getTime();
                                                    if (targetDate <= now) {
                                                        countdownElement.innerHTML = "";
                                                        messageElement.innerHTML = "Pegawai telah diterima kerja";
                                                        // Opsional: tambahkan logika untuk menangani ini jika diperlukan
                                                    } else {
                                                        var countdown = setInterval(function() {
                                                            var now = new Date().getTime();
                                                            var distance = targetDate - now;

                                                            if (distance < 0) {
                                                                clearInterval(countdown);
                                                                countdownElement.innerHTML = "";
                                                                messageElement.innerHTML = "Pegawai telah diterima kerja";
                                                                if (!roleUpdated) {
                                                                    roleUpdated = true;
                                                                    fetch('{{ route('pengumuman-akhir.updateRole', $pegawai->pengumuman_akhir->id) }}', {
                                                                            method: 'POST',
                                                                            headers: {
                                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                                'Content-Type': 'application/json'
                                                                            },
                                                                            body: JSON.stringify({
                                                                                role: 'pegawai'
                                                                            })
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            if (data.success) {
                                                                                location.reload();
                                                                            } else {
                                                                                console.error('Role update failed', data);
                                                                            }
                                                                        })
                                                                        .catch(error => {
                                                                            console.error('Error:', error);
                                                                        });
                                                                }
                                                            } else {
                                                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                                countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds +
                                                                    "s ";
                                                            }
                                                        }, 1000);
                                                    }
                                                });
                                            </script>
                                        @else
                                            <p class="text-center">Pegawai belum dipanggil kerja</p>
                                        @endif
                                    @elseif ($pegawai->pengumuman_akhir->status_akhir == 'Ditolak')
                                        <p class="text-center">Pegawai tidak diterima kerja</p>
                                    @endif
                                @else
                                    <p class="text-center">Catatan harus diisi terlebih dahulu</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        @if ($calon_pegawai)
            <table class="table table-report mt-5">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">No</th>
                        <th class="text-center whitespace-nowrap">Nama</th>
                        <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                        <th class="text-center whitespace-nowrap">No WA</th>
                        <th class="text-center whitespace-nowrap">Email</th>
                        <th class="text-center whitespace-nowrap">Status Akhir</th>
                        <th class="text-center whitespace-nowrap">Tanggal Masuk Kerja</th>
                        <th class="text-center whitespace-nowrap">Countdown Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="intro-x" style="height: 250px">
                        <td class="text-center" style="width: 70px;">1</td>
                        <td class="table-report__action font-medium text-center" style="width: 200px;">
                            {{ $calon_pegawai->name }}
                        </td>
                        <td class="table-report__action text-center" style="width: 200px;">
                            {{ $calon_pegawai->daftar && $calon_pegawai->daftar->lowongan ? $calon_pegawai->daftar->lowongan->posisi : '-' }}
                        </td>
                        <td class="table-report__action text-center" style="width: 200px;">{{ $calon_pegawai->noWA }}
                        </td>
                        <td class="table-report__action text-center" style="width: 200px;">{{ $calon_pegawai->email }}
                        </td>
                        <td class="table-report__action text-center" style="width: 200px;">
                            @if ($calon_pegawai->pengumuman_akhir)
                                @if ($calon_pegawai->pengumuman_akhir->status_akhir == 'Diterima')
                                    <span class="text-success">Diterima</span>
                                @elseif ($calon_pegawai->pengumuman_akhir->status_akhir == 'Ditolak')
                                    <span class="text-danger">Ditolak</span>
                                @else
                                    <span class="text-warning">Menunggu</span>
                                @endif
                            @else
                                <span class="text-warning">Menunggu</span>
                            @endif
                        </td>
                        <td class="table-report__action w-86 text-center" style="width: 200px;">
                            @if ($calon_pegawai->pengumuman_akhir && $calon_pegawai->pengumuman_akhir->tanggal_masuk)
                                <span>{{ \Carbon\Carbon::parse($calon_pegawai->pengumuman_akhir->tanggal_masuk)->format('d-m-Y H:i') }}</span>
                            @else
                                <p class="text-center">Tanggal masuk belum ditentukan</p>
                            @endif
                        </td>
                        <td class="table-report__action w-86 text-center" style="width: 250px;">
                            @if ($calon_pegawai->pengumuman_akhir && $calon_pegawai->pengumuman_akhir->tanggal_masuk)
                                <div class="countdown"
                                    data-tanggal-masuk="{{ $calon_pegawai->pengumuman_akhir->tanggal_masuk }}">
                                    <div class="countdown-item">
                                        <span class="countdown-timer" id="days"></span>
                                        <span class="countdown-label">Hari</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="countdown-timer" id="hours"></span>
                                        <span class="countdown-label">Jam</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="countdown-timer" id="minutes"></span>
                                        <span class="countdown-label">Menit</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="countdown-timer" id="seconds"></span>
                                        <span class="countdown-label">Detik</span>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var countdownDiv = document.querySelector('.countdown');
                                        var tanggalMasuk = new Date(countdownDiv.getAttribute('data-tanggal-masuk'));

                                        var countdownInterval = setInterval(function() {
                                            var now = new Date().getTime();
                                            var distance = tanggalMasuk - now;

                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            countdownDiv.querySelector('#days').innerText = days;
                                            countdownDiv.querySelector('#hours').innerText = hours;
                                            countdownDiv.querySelector('#minutes').innerText = minutes;
                                            countdownDiv.querySelector('#seconds').innerText = seconds;

                                            if (distance < 0) {
                                                clearInterval(countdownInterval);
                                                countdownDiv.innerHTML = "<div>Waktu sudah tiba!</div>";
                                                window.location.href = "{{ route('pegawai.index') }}";

                                            }
                                        }, 1000);
                                    });
                                </script>
                            @else
                                <p class="text-center">Tanggal masuk harus diisi terlebih dahulu</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @endif
    @endif
@endsection
<script src="js/pencarian.js"></script>
