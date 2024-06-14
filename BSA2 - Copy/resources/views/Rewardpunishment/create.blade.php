@extends('../layout/' . $layout)
@section('subhead')
    <title>Reward & Punishment</title>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Reward & Punishment</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Tambah Reward & Punishment</h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <form action="{{ route('rewardpunishment.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="mt-3">
                                            <label for="pegawai_id"
                                                class="w-full flex flex-col sm:flex-row gap-2 form-label">Nama Pegawai
                                                <span class="text-danger">*</span>
                                                <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span></label>
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
                                        <div class="input-form mt-3">
                                            <label for="jenis" class="form-label w-full flex flex-col sm:flex-row">
                                                Jenis <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <select id="jenis" name="jenis" data-search="true"
                                                class="tom-select w-full mt-2 sm:mr-2 form-control @error('jenis') border-danger @enderror"
                                                aria-label="Default select example">
                                                <option selected disabled hidden value="">Pilih Jenis</option>
                                                <option value="Reward">Reward</option>
                                                <option value="Punishment">Punishment</option>
                                            </select>
                                            @error('jenis')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-form mt-3">
                                            <label for="tanggal" class="form-label w-full flex flex-col sm:flex-row gap-2">
                                                Tanggal
                                                <span class="text-danger">*</span><span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <input type="date" name="tanggal" id="tanggal"
                                                class="form-control w-full flex flex-col sm:flex-row gap-2 form-label @error('tanggal') border-danger @enderror">
                                            @error('tanggal')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-form mt-3 w-72">
                                            <label for="foto" class="form-label w-full flex flex-col sm:flex-row">
                                                Foto <span
                                                    class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span>
                                            </label>
                                            <div
                                                class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                                <div class="text-slate-500 text-center font-medium mt-2">
                                                    <img id="previewFoto" class="rounded-md" alt="Preview Foto"
                                                        src="{{ asset('dist/images/placeholder.jpg') }}">
                                                </div>
                                                <div class="mx-auto cursor-pointer relative mt-5">
                                                    <button type="button" class="btn btn-primary w-full"
                                                        onclick="document.getElementById('inputFoto').click()">Pilih
                                                        Foto</button>
                                                    <input id="foto" type="file" name="foto"
                                                        class="w-full h-full top-0 left-0 absolute opacity-0"
                                                        onchange="previewImage(this)">
                                                    @if ($errors->has('foto'))
                                                        <div class="alert alert-outline-danger alert-dismissible show flex items-center mb-2"
                                                            role="alert">
                                                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                                                            {{ $errors->first('foto') }}
                                                            <button type="button" class="btn-close" data-tw-dismiss="alert"
                                                                aria-label="Close">
                                                                <i data-lucide="x" class="w-4 h-4"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
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
    <script src="{{ asset('js/preview_foto.js') }}"></script>
@endsection

@section('script')
    <script>
        (function() {
            async function cancel() {
                $('#btn_cancel').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>');
                tailwind.svgLoader();
                await helper.delay(1500);
                window.location.href = "{{ route('promosi.index') }}";
            }

            $('#btn_cancel').on('click', function() {
                cancel();
            });
        })();
    </script>
@endsection
