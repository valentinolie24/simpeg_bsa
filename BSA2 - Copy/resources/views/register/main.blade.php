@extends('../layout/' . $layout)

@section('head')
    <title>Register</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Register Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="Bintang Selatan Agung" class="w-6" src="{{ asset('foto/LogoKecil.png') }}">
                    <span class="text-white text-lg ml-3">
                        Bintang Selatan Agung
                    </span>
                </a>
                <div class="my-auto">
                    <img alt="Icewall Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16"
                        src="{{ asset('foto/logo-bsa.png') }}">
                    {{-- <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Perusahaan yang bergerak
                        dibidang Konstruksi Sipil</div> --}}
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">“Quality Is Our
                        Concern”</div>
                </div>
            </div>
            <!-- END: Register Info -->
            <!-- BEGIN: Register Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Daftar</h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">“Quality Is Our Concern”</div>
                    <div class="intro-x mt-8">
                        <form class="form-validate" action="{{ route('register') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- BEGIN: Validation Form -->
                            <div class="input-form mt-3">
                                <input id="name" type="text" name="name"
                                    class="intro-x form-control @error('name') border-danger @enderror" py-3 px-4 block
                                    placeholder="Nama Lengkap" value="{{ old('name') }}" minlength="2">
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-form mt-3">
                                <input id="email" type="email" name="email"
                                    class="intro-x form-control @error('email') border-danger @enderror" py-3 px-4 block
                                    placeholder="Email" value="{{ old('email') }}" minlength="2">
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-form mt-3">
                                <input id="noWA" type="text" name="noWA"
                                    class="intro-x form-control @error('noWA') border-danger @enderror" py-3 px-4 block
                                    placeholder="Nomor WhatsApp" value="{{ old('noWA') }}" minlength="2">
                                @error('noWA')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-form mt-3">
                                <input id="password" type="password" name="password"
                                    class="intro-x form-control @error('password') border-danger @enderror" py-3 px-4 block
                                    placeholder="Password" value="{{ old('password') }}" minlength="2">
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-form mt-3">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="intro-x form-control @error('password') border-danger @enderror" py-3 px-4 block
                                    placeholder="Password" value="{{ old('password') }}" minlength="2">
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit"
                                    class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Daftar</button>
                                <a href="{{ route('login') }}" id="btn-masuk"
                                    class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Masuk</a>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- END: Register Form -->
            </div>
        </div>
    </div>
@endsection

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
