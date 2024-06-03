@if ($pegawais->isEmpty())
@else
    @foreach ($pegawais as $pegawai)
        <!-- BEGIN: Modal Content -->
        <!-- BEGIN: Modal Profil -->
        <div id="profil_modal_{{ $pegawai->id }}" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Profil {{ $pegawai->nama }}</h5>
                    </div>
                    <div class="intro-y box px-5 pt-5 mt-5 mb-5">
                        <div
                            class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                                <div class="image-fit relative" style="height: 300px; width: 300px;">
                                    <img alt="Profil Pegawai" class="rounded-full"
                                        src="{{ asset('foto/' . $pegawai->foto) }}">
                                </div>
                                <div class="ml-5">
                                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                                        {{ $pegawai->nama }}</div>
                                    <div class="text-slate-500">{{ $pegawai->jabatan }}</div>
                                </div>
                            </div>
                            <div
                                class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                                <div class="font-medium text-center lg:text-left lg:mt-3">Kontak Detail</div>
                                <div id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="pr-1">
                                        <div class="box p-5 mt-5">
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                                <div>
                                                    <div class="text-slate-500">NIK</div>
                                                    <div class="mt-1">{{ $pegawai->nik }}</div>
                                                </div>
                                                <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Alamat</div>
                                                    <div class="mt-1">{{ $pegawai->alamat }}</div>
                                                </div>
                                                <i data-lucide="home" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Tanggal Lahir</div>
                                                    <div class="mt-1">{{ $pegawai->ttl }}</div>
                                                </div>
                                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Tanggal Masuk Kerja</div>
                                                    <div class="mt-1">{{ $pegawai->tanggal_masuk }}</div>
                                                </div>
                                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Pendidikan</div>
                                                    <div class="mt-1">{{ $pegawai->pendidikan }}</div>
                                                </div>
                                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Status</div>
                                                    <div class="mt-1">{{ $pegawai->status }}</div>
                                                </div>
                                                <i data-lucide="heart" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Agama</div>
                                                    <div class="mt-1">{{ $pegawai->agama }}</div>
                                                </div>
                                                <i data-lucide="shield" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div
                                                class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Status Pekerjaan</div>
                                                    <div class="mt-1">{{ $pegawai->status_pekerjaan }}</div>
                                                </div>
                                                <i data-lucide="briefcase" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Tutup</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- END: Modal Profil -->
    @endforeach
@endif
