<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\PengumumanAkhirController;
use App\Http\Controllers\PromosiController;
use App\Http\Controllers\DemosiController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');


Route::controller(AuthController::class)->middleware('loggedin')->group(function() {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
    Route::get('register', 'registerView')->name('register.main');
    Route::post('register', 'register')->name('register');
});


Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::controller(PageController::class)->group(function() {
        Route::get('dashboard-overview-1-page', 'dashboardOverview1')->name('dashboard-overview-1');
        Route::get('dashboard-overview-2-page', 'dashboardOverview2')->name('dashboard-overview-2');
        Route::get('dashboard-overview-3-page', 'dashboardOverview3')->name('dashboard-overview-3');
        Route::get('/', 'dashboardOverview4')->name('dashboard-overview-4');
        Route::get('inbox-page', 'inbox')->name('inbox');
        Route::get('file-manager-page', 'fileManager')->name('file-manager');
        Route::get('point-of-sale-page', 'pointOfSale')->name('point-of-sale');
        Route::get('chat-page', 'chat')->name('chat');
        Route::get('post-page', 'post')->name('post');
        Route::get('calendar-page', 'calendar')->name('calendar');
        Route::get('crud-data-list-page', 'crudDataList')->name('crud-data-list');
        Route::get('crud-form-page', 'crudForm')->name('crud-form');
        Route::get('users-layout-1-page', 'usersLayout1')->name('users-layout-1');
        Route::get('users-layout-2-page', 'usersLayout2')->name('users-layout-2');
        Route::get('users-layout-3-page', 'usersLayout3')->name('users-layout-3');
        Route::get('profile-overview-1-page', 'profileOverview1')->name('profile-overview-1');
        Route::get('profile-overview-2-page', 'profileOverview2')->name('profile-overview-2');
        Route::get('profile-overview-3-page', 'profileOverview3')->name('profile-overview-3');
        Route::get('wizard-layout-1-page', 'wizardLayout1')->name('wizard-layout-1');
        Route::get('wizard-layout-2-page', 'wizardLayout2')->name('wizard-layout-2');
        Route::get('wizard-layout-3-page', 'wizardLayout3')->name('wizard-layout-3');
        Route::get('blog-layout-1-page', 'blogLayout1')->name('blog-layout-1');
        Route::get('blog-layout-2-page', 'blogLayout2')->name('blog-layout-2');
        Route::get('blog-layout-3-page', 'blogLayout3')->name('blog-layout-3');
        Route::get('pricing-layout-1-page', 'pricingLayout1')->name('pricing-layout-1');
        Route::get('pricing-layout-2-page', 'pricingLayout2')->name('pricing-layout-2');
        Route::get('invoice-layout-1-page', 'invoiceLayout1')->name('invoice-layout-1');
        Route::get('invoice-layout-2-page', 'invoiceLayout2')->name('invoice-layout-2');
        Route::get('faq-layout-1-page', 'faqLayout1')->name('faq-layout-1');
        Route::get('faq-layout-2-page', 'faqLayout2')->name('faq-layout-2');
        Route::get('faq-layout-3-page', 'faqLayout3')->name('faq-layout-3');
        Route::get('login-page', 'login')->name('login');
        // Route::get('register-page', 'register')->name('register');
        Route::get('error-page-page', 'errorPage')->name('error-page');
        Route::get('update-profile-page', 'updateProfile')->name('update-profile');
        Route::get('change-password-page', 'changePassword')->name('change-password');
        Route::get('regular-table-page', 'regularTable')->name('regular-table');
        Route::get('tabulator-page', 'tabulator')->name('tabulator');
        Route::get('modal-page', 'modal')->name('modal');
        Route::get('slide-over-page', 'slideOver')->name('slide-over');
        Route::get('notification-page', 'notification')->name('notification');
        Route::get('tab-page', 'tab')->name('tab');
        Route::get('accordion-page', 'accordion')->name('accordion');
        Route::get('button-page', 'button')->name('button');
        Route::get('alert-page', 'alert')->name('alert');
        Route::get('progress-bar-page', 'progressBar')->name('progress-bar');
        Route::get('tooltip-page', 'tooltip')->name('tooltip');
        Route::get('dropdown-page', 'dropdown')->name('dropdown');
        Route::get('typography-page', 'typography')->name('typography');
        Route::get('icon-page', 'icon')->name('icon');
        Route::get('loading-icon-page', 'loadingIcon')->name('loading-icon');
        Route::get('regular-form-page', 'regularForm')->name('regular-form');
        Route::get('datepicker-page', 'datepicker')->name('datepicker');
        Route::get('tom-select-page', 'tomSelect')->name('tom-select');
        Route::get('file-upload-page', 'fileUpload')->name('file-upload');
        Route::get('wysiwyg-editor-classic', 'wysiwygEditorClassic')->name('wysiwyg-editor-classic');
        Route::get('wysiwyg-editor-inline', 'wysiwygEditorInline')->name('wysiwyg-editor-inline');
        Route::get('wysiwyg-editor-balloon', 'wysiwygEditorBalloon')->name('wysiwyg-editor-balloon');
        Route::get('wysiwyg-editor-balloon-block', 'wysiwygEditorBalloonBlock')->name('wysiwyg-editor-balloon-block');
        Route::get('wysiwyg-editor-document', 'wysiwygEditorDocument')->name('wysiwyg-editor-document');
        Route::get('validation-page', 'validation')->name('validation');
        Route::get('chart-page', 'chart')->name('chart');
        Route::get('slider-page', 'slider')->name('slider');
        Route::get('image-zoom-page', 'imageZoom')->name('image-zoom');
    });
    Route::get('pegawai/index', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::resource('pegawai', PegawaiController::class);
    Route::get('/cari', [PegawaiController::class, 'Pencarian'])->name('cari');
    Route::get('/cari_lowongan', [LowonganController::class, 'Pencarian'])->name('cari_lowongan');
    Route::get('/cari_administrasi', [AdministrasiController::class, 'Pencarian'])->name('cari_administrasi');
    Route::get('/cari_tes', [TesController::class, 'Pencarian'])->name('cari_tes');
    Route::get('/cari_pengumuman_akhir', [PengumumanAkhirController::class, 'Pencarian'])->name('cari_pengumuman_akhir');
    Route::get('lowongan/index', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::resource('lowongan', LowonganController::class);
    Route::get('daftar/index', [DaftarController::class, 'index'])->name('daftar.index');
    Route::resource('daftar', DaftarController::class);
    Route::get('administrasi/index', [AdministrasiController::class, 'index'])->name('administrasi.index');
    Route::resource('administrasi', AdministrasiController::class);
    Route::patch('/administrasi/accept/{id}', [AdministrasiController::class, 'accept'])->name('administrasi.accept');
    Route::patch('/administrasi/reject/{id}', [AdministrasiController::class, 'reject'])->name('administrasi.reject');
    Route::post('/administrasi/{id}/saveNote', [AdministrasiController::class, 'saveNote'])->name('administrasi.saveNote');
    Route::get('tes/index', [TesController::class, 'index'])->name('tes.index');
    Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
    Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
    Route::patch('/tes/{id}', [TesController::class, 'update'])->name('tes.update');
    Route::patch('/tes/accept/{id}', [TesController::class, 'accept'])->name('tes.accept');
    Route::patch('/tes/reject/{id}', [TesController::class, 'reject'])->name('tes.reject');
    Route::post('/tes/save-note/{id}', [TesController::class, 'saveNote'])->name('tes.saveNote');
    // Route::post('/tes/save-note/{id}', 'TesController@saveNote')->name('tes.saveNote');    
    Route::get('/pengumuman-akhir', [PengumumanAkhirController::class, 'index'])->name('pengumuman-akhir.index');
    Route::patch('/pengumuman-akhir/accept/{id}', [PengumumanAkhirController::class, 'accept'])->name('pengumuman-akhir.accept');
    Route::patch('/pengumuman-akhir/reject/{id}', [PengumumanAkhirController::class, 'reject'])->name('pengumuman-akhir.reject');
    Route::post('/pengumuman-akhir/save-note/{id}', [PengumumanAkhirController::class, 'saveNote'])->name('pengumuman-akhir.saveNote');
    Route::post('/pengumuman-akhir/{id}/update-tanggal-masuk', [PengumumanAkhirController::class, 'updateTanggalMasuk'])->name('pengumuman-akhir.updateTanggalMasuk');
    Route::post('/pengumuman-akhir/update-role/{id}', [PengumumanAkhirController::class, 'updateRole'])->name('pengumuman-akhir.updateRole');

    Route::get('jabatan/index', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::resource('jabatan', JabatanController::class);
    Route::get('/cari_jabatan', [JabatanController::class, 'Pencarian'])->name('cari_jabatan');

    Route::get('promosi/index', [PromosiController::class, 'index'])->name('promosi.index');
    Route::resource('promosi', PromosiController::class);
    Route::get('/promosi/jabatan-lain/{pegawaiId}', [PromosiController::class, 'getJabatanLain']);
    Route::patch('/promosi/accept/{id}', [PromosiController::class, 'accept'])->name('promosi.accept');
    Route::patch('/promosi/reject/{id}', [PromosiController::class, 'reject'])->name('promosi.reject');
    Route::post('/promosi/save-note/{id}', [PromosiController::class, 'saveNote'])->name('promosi.saveNote');
    Route::get('/cari_promosi', [PromosiController::class, 'Pencarian'])->name('cari_promosi');

    Route::get('demosi/index', [DemosiController::class, 'inDex'])->name('Demosi.index');
    Route::resource('demosi', DemosiController::class);
    Route::get('/demosi/jabatan-lain/{pegawaiId}', [DemosiController::class, 'getJabatanLain']);
    Route::patch('/demosi/accept/{id}', [DemosiController::class, 'accept'])->name('demosi.accept');
    Route::patch('/demosi/reject/{id}', [DemosiController::class, 'reject'])->name('demosi.reject');
    Route::post('/demosi/save-note/{id}', [DemosiController::class, 'saveNote'])->name('demosi.saveNote');
    Route::get('/cari_demosi', [DemosiController::class, 'Pencarian'])->name('cari_demosi');
});

Route::get('joblist', [LowonganController::class, 'loker'])->name('lowongan.loker');
Route::get('Pencarian_notlogin', [LowonganController::class, 'Pencarian_notlogin'])->name('lowongan.Pencarian_notlogin');
