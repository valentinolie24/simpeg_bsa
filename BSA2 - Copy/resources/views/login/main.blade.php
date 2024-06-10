@extends('../layout/' . $layout)

@section('head')
    <title>Login</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
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
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Masuk</h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">“Quality Is Our Concern”</div>
                    <div class="intro-x mt-8">
                        <form id="login-form">
                            <input id="email" type="text" class="intro-x login__input form-control py-3 px-4 block"
                                placeholder="Email">
                            <div id="error-email" class="login__input-error text-danger mt-2"></div>
                            <input id="password" type="password"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">
                            <div id="error-password" value="password" class="login__input-error text-danger mt-2"></div>
                        </form>
                    </div>
                    <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                        </div>
                        <a href="{{ route('lowongan.loker') }}">Lupa Password?</a>
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button id="btn-login"
                            class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Masuk</button>

                        <button id="btn-daftar"
                            class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Daftar</button>
                    </div>
                    <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                        Dengan mendaftar, Anda menyetujui Syarat dan Ketentuan & Kebijakan Privasi kami</a>
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function() {
            async function login() {
                // Reset state
                $('#login-form').find('.login__input').removeClass('border-danger')
                $('#login-form').find('.login__input-error').html('')

                // Post form
                let email = $('#email').val()
                let password = $('#password').val()

                // Loading state
                $('#btn-login').html(
                    '<i data-loading-icon="tail-spin" data-color="white" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                axios.post(`login`, {
                    email: email,
                    password: password
                }).then(res => {
                    location.href = '/lowongan/index'
                }).catch(err => {
                    $('#btn-login').html('Login')
                    if (err.response.data.message != 'Wrong email or password.') {
                        for (const [key, val] of Object.entries(err.response.data.errors)) {
                            $(`#${key}`).addClass('border-danger')
                            $(`#error-${key}`).html(val)
                        }
                    } else {
                        $(`#password`).addClass('border-danger')
                        $(`#error-password`).html(err.response.data.message)
                    }
                })
            }

            $('#btn-daftar').on('click', function() {
                register();
            });

            async function register() {
                // Loading state
                $('#btn-daftar').html(
                    '<i data-loading-icon="tail-spin" data-color="black" class="w-5 h-5 mx-auto"></i>')
                tailwind.svgLoader()
                await helper.delay(1500)

                // Redirect to register page
                window.location.href = "{{ route('register.main') }}";
            }
            // // Tambahkan di bawah kode JavaScript yang sudah ada
            // $('#btn-register').on('click', function() {
            //     window.location.href = "{{ route('register.main') }}";
            // });


            $('#login-form').on('keyup', function(e) {
                if (e.keyCode === 13) {
                    login()
                }
            })

            $('#btn-login').on('click', function() {
                login()
            })
        })()
    </script>
@endsection
