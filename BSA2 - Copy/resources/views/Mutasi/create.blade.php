@extends('../layout/' . $layout)
@section('subhead')
    <title>Tambah Mutasi</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Tambah Mutasi</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Tambah Mutasi</h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <form action="{{ route('mutasi.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="mt-3">
                                            <label for="pegawai_id"
                                                class="w-full flex flex-col sm:flex-row gap-2 form-label">Nama Pegawai
                                                <span class="text-danger">*</span>
                                                <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="pegawai_id" name="pegawai_id"
                                                class="tom-select form-control @error('pegawai_id') border-danger @enderror">
                                                <option selected disabled hidden value="">Pilih Pegawai</option>
                                                @foreach ($pegawai as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('pegawai_id')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <label for="cabang_lama"
                                                class="w-full flex flex-col sm:flex-row gap-2 form-label">
                                                Cabang Lama
                                                <span class="text-danger">*</span>
                                                <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input id="cabang_lama" type="text" class="form-control" disabled>
                                            <input type="hidden" name="cabang_lama" id="hidden_cabang_lama">
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="cabang_baru"
                                                class="form-label w-full flex flex-col sm:flex-row gap-2">
                                                Cabang Baru
                                                <span class="text-danger">*</span>
                                                <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="cabang_baru" name="cabang_baru" data-search="true"
                                                class="w-full mt-2 sm:mr-2 form-control @error('cabang_baru') border-danger @enderror">
                                                <option selected disabled hidden value="">Pilih Cabang Baru</option>
                                                @foreach ($cabangs as $cabang)
                                                    <option value="{{ $cabang->nama_cabang }}">{{ $cabang->nama_cabang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cabang_baru')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="tanggal_mutasi"
                                                class="form-label w-full flex flex-col sm:flex-row gap-2">
                                                Tanggal Mutasi
                                                <span class="text-danger">*</span><span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input type="date" name="tanggal_mutasi" id="tanggal_mutasi"
                                                class="form-control w-full flex flex-col sm:flex-row gap-2 form-label @error('tanggal_mutasi') border-danger @enderror">
                                            @error('tanggal_mutasi')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left mt-5">
                                    <a id="btn_cancel" class="btn btn-outline-secondary w-24 mr-1">
                                        Cancel
                                    </a>
                                    <button id="btn_save" type="submit" class="btn btn-primary w-24">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function() {
            async function cancel() {
                $('#btn_cancel').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>');
                tailwind.svgLoader();
                await helper.delay(1500);
                window.location.href = "{{ route('mutasi.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel();
            });

            document.addEventListener('DOMContentLoaded', function() {
                var pegawaiSelect = document.getElementById('pegawai_id');
                var cabangLamaInput = document.getElementById('cabang_lama');
                var hiddenCabangLama = document.getElementById('hidden_cabang_lama');
                var cabangBaruSelect = document.getElementById('cabang_baru');

                pegawaiSelect.addEventListener('change', function() {
                    var pegawaiId = this.value;

                    if (pegawaiId) {
                        fetch(`/mutasi/cabang-lama/${pegawaiId}`)
                            .then(response => response.json())
                            .then(data => {
                                cabangLamaInput.value = data.nama_cabang;
                                hiddenCabangLama.value = data.nama_cabang;
                                filterCabangBaru(data.nama_cabang);
                            })
                            .catch(error => console.error('Error fetching cabang data:', error));
                    } else {
                        cabangLamaInput.value = '';
                        hiddenCabangLama.value = '';
                        resetCabangBaruOptions();
                    }
                });

                function filterCabangBaru(cabangLamaNama) {
                    const options = cabangBaruSelect.options;
                    const optionList = Array.from(options);

                    resetCabangBaruOptions();

                    optionList.forEach(option => {
                        if (option.value === cabangLamaNama) {
                            option.style.display = 'none';
                        }
                    });
                }

                function resetCabangBaruOptions() {
                    const options = cabangBaruSelect.options;
                    Array.from(options).forEach(option => {
                        option.style.display = '';
                    });
                }
            });
        })();
    </script>

    {{-- <script>
        (function() {
            async function cancel() {
                $('#btn_cancel').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>');
                tailwind.svgLoader();
                await helper.delay(1500);
                window.location.href = "{{ route('mutasi.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel();
            });

            document.addEventListener('DOMContentLoaded', function() {
                var pegawaiSelect = document.getElementById('pegawai_id');
                var cabangLamaInput = document.getElementById('cabang_lama');
                var hiddenCabangLama = document.getElementById('hidden_cabang_lama');
                var cabangBaruSelect = document.getElementById('cabang_baru');

                pegawaiSelect.addEventListener('change', function() {
                    var pegawaiId = this.value;

                    if (pegawaiId) {
                        fetch(`/mutasi/cabang-lama/${pegawaiId}`)
                            .then(response => response.json())
                            .then(data => {
                                cabangLamaInput.value = data.nama_cabang;
                                hiddenCabangLama.value = data.nama_cabang;
                                filterCabangBaru(data.id);
                            })
                            .catch(error => console.error('Error fetching cabang data:', error));
                    } else {
                        cabangLamaInput.value = '';
                        hiddenCabangLama.value = '';
                        resetCabangBaruOptions();
                    }
                });

                function filterCabangBaru(cabangLamaId) {
                    const options = cabangBaruSelect.options;
                    const optionList = Array.from(options);

                    resetCabangBaruOptions();

                    optionList.forEach(option => {
                        if (option.value === cabangLamaId) {
                            option.style.display = 'none';
                        }
                    });
                }

                function resetCabangBaruOptions() {
                    const options = cabangBaruSelect.options;
                    Array.from(options).forEach(option => {
                        option.style.display = '';
                    });
                }
            });

        })();
    </script> --}}
@endsection
