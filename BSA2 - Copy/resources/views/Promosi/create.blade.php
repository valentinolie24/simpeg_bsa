@extends('../layout/' . $layout)
@section('subhead')
    <title>Promosi</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Promosi</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Tambah Promosi</h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <form action="{{ route('promosi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="mt-3">
                                            <label for="pegawai_id" class="form-label">Nama Pegawai <span
                                                    class="text-danger">*</span></label>
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
                                            <label for="jabatan_lama" class="form-label">Jabatan Lama</label>
                                            <input id="jabatan_lama" type="text" class="form-control" disabled>
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="jabatan_baru" class="form-label w-full flex flex-col sm:flex-row">
                                                Jabatan Baru<span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="jabatan_baru" name="jabatan_baru" data-search="true"
                                                class="w-full mt-2 sm:mr-2 form-control @error('jabatan_baru') border-danger @enderror"
                                                aria-label="Default select example">
                                                <option selected disabled hidden value="">Pilih Jabatan Baru</option>
                                                @foreach ($jabatans as $jabatan)
                                                    <option value="{{ $jabatan->nama_jabatan }}">
                                                        {{ $jabatan->nama_jabatan }}</option>
                                                @endforeach
                                            </select>
                                            @error('jabatan_baru')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="tanggal_promosi"
                                                class="form-label w-full flex flex-col sm:flex-row">
                                                Tanggal Promosi <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input type="datetime-local" name="tanggal_promosi" class="form-control"
                                                id="tanggal_promosi" required>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var tanggalMasukInput = document.getElementById('tanggal_promosi');
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
            async function save() {
                // Loading state
                $('#btn_save').html(
                    '<i data-loading-icon="tail-spin" data-color="white" class="w-5 h-5 mx-auto"></i>');
                tailwind.svgLoader();
                await helper.delay(1500);

                // Redirect to register page
                window.location.href = "";
            }

            $('#btn_save').on('click', function(event) {
                event.preventDefault();
                save();
            });

            async function cancel() {
                // Loading state
                $('#btn_cancel').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>');
                tailwind.svgLoader();
                await helper.delay(1500);

                // Redirect to register page
                window.location.href = "{{ route('promosi.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel();
            });

            document.addEventListener('DOMContentLoaded', function() {
                var pegawaiSelect = document.getElementById('pegawai_id');
                var jabatanLamaInput = document.getElementById('jabatan_lama');
                var jabatanBaruSelect = document.getElementById('jabatan_baru');

                pegawaiSelect.addEventListener('change', function() {
                    var pegawaiId = this.value;

                    if (pegawaiId) {
                        fetch(`/pegawai/${pegawaiId}`)
                            .then(response => response.json())
                            .then(data => {
                                jabatanLamaInput.value = data.jabatan;
                                filterJabatanBaru(data.jabatan);
                            })
                            .catch(error => console.error('Error fetching pegawai data:', error));
                    } else {
                        jabatanLamaInput.value = '';
                        resetJabatanBaruOptions();
                    }
                });

                function filterJabatanBaru(jabatanLama) {
                    const options = jabatanBaruSelect.options;
                    const optionList = Array.from(options);

                    // Reset dropdown to show all options initially
                    resetJabatanBaruOptions();

                    // Filter options to hide the jabatan that matches jabatanLama
                    optionList.forEach(option => {
                        if (option.value === jabatanLama) {
                            option.style.display = 'none';
                        }
                    });
                }

                function resetJabatanBaruOptions() {
                    const options = jabatanBaruSelect.options;
                    Array.from(options).forEach(option => {
                        option.style.display = '';
                    });
                }
            });
        })();
    </script>
@endsection
