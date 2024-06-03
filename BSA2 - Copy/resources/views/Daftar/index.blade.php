@extends('../layout/' . $layout)
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Form Pendaftaran</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Formulir Pendaftaran</h2>
                </div>
                <div id="form-validation" class="p-5">
                    <div class="preview">
                        <form action="{{ route('daftar.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- BEGIN: Validation Form -->
                            <div class="p-5 flex flex-col items-center">
                                <div class="h-40 2xl:h-56 image-fit flex justify-center items-center mb-5"
                                    style="height: 500px; width: 500px;">
                                    <img alt="Foto Lowongan" class="rounded-md"
                                        src="{{ asset('foto/' . $lowongan->foto) }}">
                                </div>
                                <a class="block font-medium text-lg">{{ $lowongan->posisi }}</a>
                            </div>
                    </div>
                    <input type="hidden" name="lowongan_id" value="{{ request('lowongan_id') }}">

                    <div class="form-group col-lg-3 col-md-6 col-sm-12">
                        <label for="cv" class="form-label w-full flex flex-col sm:flex-row">
                            CV <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                        </label>
                        <div class="file-upload">
                            <input type="file" class="mb-2 custom-file-input @error('cv') border-danger @enderror"
                                id="cv" name="cv" value="{{ old('cv') }}" class="inputfile" accept=".pdf">
                        </div>

                        @if (!$errors->has('cv'))
                            <span class="text-danger mt-2">*Ukuran File Maks 2 MB | Format .pdf</span>
                        @endif

                        @error('cv')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-sm-12">
                        <label for="surat_lamaran" class="mt-5 form-label w-full flex flex-col sm:flex-row">
                            Surat Lamaran <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                        </label>
                        <div class="file-upload">
                            <input type="file"
                                class="mb-2 custom-file-input @error('surat_lamaran') border-danger @enderror"
                                id="surat_lamaran" name="surat_lamaran" value="{{ old('surat_lamaran') }}" class="inputfile"
                                accept=".pdf">
                        </div>

                        @if (!$errors->has('surat_lamaran'))
                            <span class="text-danger mt-2">*Ukuran File Maks 2 MB | Format .pdf</span>
                        @endif

                        @error('surat_lamaran')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-sm-12">
                        <label for="data_pendukung" class="mt-5 form-label w-full flex flex-col sm:flex-row">
                            Data Pendukung <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Opsional</span>
                        </label>
                        <div class="file-upload">
                            <input type="file"
                                class="mb-2 custom-file-input @error('data_pendukung') border-danger @enderror"
                                id="data_pendukung" name="data_pendukung" value="{{ old('data_pendukung') }}"
                                class="inputfile" accept=".pdf">
                        </div>

                        @if (!$errors->has('data_pendukung'))
                            <span class="mt-2">*Ukuran File Maks 2 MB | Format .pdf</span>
                        @endif

                        @error('data_pendukung')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-right mt-5">
                        <a id="btn_cancel"
                            class="btn btn-outline-secondary w-24
                                mr-1">Cancel</a>
                        <button id="btn_save" type="submit" class="btn btn-primary w-24">Save</button>
                    </div>
                    </form>

                </div>

            </div>
            <!-- END: Validation Form -->
        </div>
    </div>
    </div>
    <script src="{{ asset('js/preview_foto.js') }}"></script>
    {{-- <script src="{{ asset('js/validation.js') }}"></script> --}}
@endsection

@section('script')
    <script>
        (function() {
            async function save() {
                // Loading state
                $('#btn_save').html(
                    '<i data-loading-icon="tail-spin" data-color="white" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "";
            }

            $('#btn_save').on('click', function() {

                // Mendapatkan id lowongan yang dipilih
                var lowongan_id = $(this).closest('.box').find('input[name="lowongan_id"]').val();
                // Menyimpan id lowongan yang dipilih ke dalam input hidden
                $('#lowongan_id').val(lowongan_id);
                // Mengirimkan formulir pendaftaran
                $('#form_pendaftaran').submit();
                save()
            })

            async function cancel() {
                // Loading state
                $('#btn_cancel').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "{{ route('lowongan.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel()
            })

        })()
    </script>
@endsection
@push('styles')
    <style>
        .custom-file-input {
            width: 100%;
            padding: 10px;
            height: auto;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-sizing: border-box;
        }

        .custom-file-input:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .custom-file-input.border-danger {
            border-color: #e3342f;
        }
    </style>
@endpush
