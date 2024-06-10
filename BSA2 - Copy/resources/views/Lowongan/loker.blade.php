<!DOCTYPE html>
<!--
Template Name: Enigma - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ $dark_mode ? 'dark' : '' }}{{ $color_scheme != 'default' ? ' ' . $color_scheme : '' }}">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Enigma admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Enigma Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">

    @yield('head')

    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />
    @stack('styles')
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="container">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Halaman Lowongan</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="{{ route('lowongan.Pencarian_notlogin') }}" method="get" id="form_pencarian"
                    class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <input id="nama_pencarian" name="nama_pencarian" type="text"
                            class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari Lowongan...">
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button class="btn btn-primary shadow-md mr-2">Cari</button>
                        <a type="button" id="reset_pencarian" href="{{ route('lowongan.index') }}"
                            class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset</a>
                    </div>
                </form>
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
            </div>
        </div>
    </div>
    @if ($lowongans->isEmpty())
        <p class="text-center mt-5">Tidak ada data yang ditemukan.</p>
    @else
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            @foreach ($lowongans as $lowongan)
                <div class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                        <div class="ml-3 mr-auto">
                            <a class="font-extrabold block font-medium text-base">{{ $lowongan->posisi }}</a>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="h-40 2xl:h-56 image-fit" style="height: 500px">
                            <img alt="Foto Lowongan" class="rounded-md" src="{{ asset('foto/' . $lowongan->foto) }}">
                        </div>
                        <a class="block font-medium text-base mt-5">{{ $lowongan->posisi }}</a>
                        <div class="text-slate-600 dark:text-slate-500 mt-2">{{ $lowongan->deskripsi }}
                        </div>
                    </div>
                    <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="intro-x flex mr-2">
                            <i data-lucide="tag" class="w-4 h-4 mt-0.5 mr-2"></i><span
                                class="mt-0.25">{{ $lowongan->gaji }}</span>
                        </div>
                    </div>
                    <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="ml-auto">Jumlah Lamaran : {{ $lowongan->daftar()->count() }}</div>
                    </div>
                    <input id="lowongan_id" type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                    <div class="px-5 pt-3 pb-5 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="w-full flex text-slate-500 text-xs sm:text-sm">
                            <div class="text-right mt-5">

                                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                    <button type="submit"
                                        class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Daftar</button>
                                    <a href="{{ route('login') }}" id="btn-masuk"
                                        class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Masuk</a>
                                </div>
                            </div>
                            <div class="ml-auto"> Ditambahkan pada <span
                                    class="font-medium">{{ $lowongan->created_at->locale('id')->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</body>

@section('script')
    <script>
        (function() {
            async function login() {
                // Loading state
                $('#btn-masuk').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "{{ route('login') }}";
            }

            $('#btn-masuk').on('click', function() {
                login()
            })

        })()
    </script>
@endsection

</html>
