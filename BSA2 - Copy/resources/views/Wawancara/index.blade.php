@extends('../layout/' . $layout)
@section('subhead')
    <title>Wawancara</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Wawancara</h2>
    </div>
    <br>

    <div class="overflow-x-auto">
        @if ($calon_pegawai->isEmpty())
            <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
        @else
            <table class="table table-report mt-5">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">No</th>
                        <th class="text-center whitespace-nowrap">Posisi Dilamar</th>
                        <th class="text-center whitespace-nowrap">Nama Pelamar</th>
                        <th class="text-center whitespace-nowrap">Tanggal Wawancara</th>
                        <th class="text-center whitespace-nowrap">Status Wawancara</th>
                        <th class="text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($calon_pegawai as $pegawai)
                        <tr class="intro-x" style="height: 250px">
                            <td class="text-center" style="width: 70px;">{{ $no++ }}</td>
                            <td class="table-report__action text-center" style="width: 200px;">
                                {{ $pegawai->daftar && $pegawai->daftar->lowongan ? $pegawai->daftar->lowongan->posisi : '-' }}
                            </td>
                            <td class="table-report__action font-medium whitespace-nowrap text-center"
                                style="width: 250px;">
                                {{ $pegawai->name }}
                            </td>
                            <td>
                                @if ($pegawai->tes)
                                    {{ $pegawai->name ?? 'Belum Dijadwalkan' }}
                                @else
                                    <span class="text-warning">Belum Dijadwalkan</span>
                                @endif
                            </td>
                            <td>
                                @if ($pegawai->tes)
                                    @if ($pegawai->name == 'Diterima')
                                        <span class="text-success">Diterima</span>
                                    @else
                                        <span class="text-danger">Ditolak</span>
                                    @endif
                                @else
                                    <span class="text-warning">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if ($pegawai->tes)
                                    @if (!$pegawai->name)
                                        <form action="{{ route('wawancara.schedule', $pegawai->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            <input type="datetime-local" name="tanggal_wawancara" class="form-control"
                                                required>
                                            <button class="btn btn-primary mt-2" type="submit">Jadwalkan Wawancara</button>
                                        </form>
                                    @endif
                                    @if ($pegawai->name == 'Menunggu')
                                        <form action="{{ route('wawancara.updateStatus', $pegawai->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_wawancara" value="Diterima">
                                            <button class="btn btn-success mt-2" type="submit">Terima</button>
                                        </form>
                                        <form action="{{ route('wawancara.updateStatus', $pegawai->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_wawancara" value="Ditolak">
                                            <button class="btn btn-danger mt-2" type="submit">Tolak</button>
                                        </form>
                                    @endif
                                @else
                                    <button class="btn btn-secondary mt-2" disabled>Sudah Dijadwalkan</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
