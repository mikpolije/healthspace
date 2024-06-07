<?php

use App\Http\Controllers\Admin\DaftarInvoiceController;
use App\Http\Controllers\Admin\DaftarKonsultasiController;
use App\Http\Controllers\Admin\DaftarPasienController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\Pasien\DashboardPasienController;
use App\Http\Controllers\Pasien\KonsultasiController as KonsultasiPasienController;

use App\Http\Controllers\Healthspace\HomepageController;
use App\Http\Controllers\Aduan\MainController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PoliController as AdminPoliController;
use App\Http\Controllers\Admin\DokterController as AdminDokterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\Dokter\ChatKonsultasiController;
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Dokter\JadwalPraktikDokterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Dokter\KonsultasiController as KonsultasiDokterController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/', [LandingPageController::class, 'index']);

Route::get('login', [AuthController::class, 'login']);
Route::get('register', function () {
    return view('register');
});

Route::post('postlogin', [AuthController::class, 'postlogin']);
Route::post('postregister', [AuthController::class, 'postregister']);

Route::get('login-google-auth', [AuthController::class, 'redirectToProvider']);
    Route::get('login-google-auth/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('logout', [AuthController::class, 'logout']);

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactFormController::class, 'submit'])->name('contact.submit');

Route::post('/send-email',[ContactController::class, 'sendEmail'])->name('send.email');

Route::get('/homepage', [HomepageController::class, 'show'])->name('homepage');
Route::get('/aduan',    [MainController::class, 'index'])->name('aduan-main');

Route::middleware(['role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('dashboard', AdminDashboardController::class);
        Route::resource('poli', AdminPoliController::class);

        Route::resource('dokter', AdminDokterController::class);
        Route::post('dokter/update/{id}', [AdminDokterController::class, 'updates']);
        Route::get('dokter/hapus/{id}', [AdminDokterController::class, 'destroy']);

        Route::resource('daftar-pasien', DaftarPasienController::class);
        Route::post('daftar-pasien/update/{id}', [DaftarPasienController::class, 'updates']);
        Route::get('daftar-pasien/hapus/{id}', [DaftarPasienController::class, 'destroy']);

        Route::resource('daftar-konsultasi', DaftarKonsultasiController::class);
        Route::get('hasil_konsultasi/{id}', [DaftarKonsultasiController::class,'hasil_konsultasi']);
        Route::get('riwayat_konsul/{id}', [DaftarKonsultasiController::class,'riwayat_konsultasi']);
        Route::get('no_catatan_resep/{id}', [DaftarKonsultasiController::class, 'no_catatan_resep'])->name('no_catatan_resep');        


        Route::resource('invoice', DaftarInvoiceController::class);
        Route::get('riwayat-konsultasi/{pasien}',[DaftarKonsultasiController::class,'index_chat']);
        
        Route::get('getchat/{id}/{pasien}',[DaftarKonsultasiController::class,'getChat_riwayat']);
    });
});


Route::middleware(['role:pasien'])->group(function () {
    Route::prefix('pasien')->group(function () {
        Route::get('/dashboard',[DashboardPasienController::class,'index']);
        Route::get('profil-pasien', [AuthController::class, 'profil_pasien']);
        Route::post('profil_pasien_update/{id}', [AuthController::class, 'profil_pasien_update']);

        Route::get('konsultasi',[KonsultasiPasienController::class,'index']);
        Route::post('konsultasi/lihatcatatan', [KonsultasiDokterController::class, 'lihatCatatan']);
        Route::post('pemesanan',[DashboardPasienController::class,'pemesanan']);
        Route::get('pemesanan/{id}',[DashboardPasienController::class,'pemesanan_view']);

    });
});


Route::middleware(['role:dokter'])->group(function () {
    Route::prefix('dokter')->group(function () {
      
        Route::get('dashboard', [DashboardDokterController::class, 'index']);
        Route::get('konsultasi', [KonsultasiDokterController::class, 'index']);
        Route::post('konsultasi/catatan', [KonsultasiDokterController::class, 'kirimCatatan']);
        Route::post('konsultasi/resep', [KonsultasiDokterController::class, 'kirimResep']);
        Route::post('konsultasi/lihatcatatan', [KonsultasiDokterController::class, 'lihatCatatan']);

        Route::post('sendchat',[KonsultasiDokterController::class,'sendChat']);
        Route::get('getchat/{id}',[KonsultasiDokterController::class,'getChat']);
        

        Route::get('profil-dokter', [AuthController::class, 'profil_dokter']);
        Route::post('profil_dokter_update/{id}', [AuthController::class, 'profil_dokter_update']);


        Route::get('diagnosa-resep', [ChatKonsultasiController::class, 'konsultasi']);
        Route::get('geticds',[KonsultasiDokterController::class,'getIcds']);


    });
});


Route::get('/pemesanan', function () {
    return view('pasien.pemesanan');
});

Route::post('proses-pemesanan', [PasienController::class, 'prosesbooking']);
Route::get('pemesanan-pending', [PasienController::class, 'bookingpending'])->name('pemesanan-pending');
Route::get('cancel-payment/{id}', [PasienController::class, 'bookingcancel'])->name('cancel.payment');


    Route::resource('dokter/jadwal_praktiks', JadwalPraktikDokterController::class);
    Route::post('dokter/jadwal_praktik/update/{id}', [JadwalPraktikDokterController::class, 'updates']);
    Route::get('dokter/jadwal_praktik/{id_dokter}', [JadwalPraktikDokterController::class, 'index_jadwal']);
    Route::get('dokter/jadwal_praktik/{id_dokter}', [JadwalPraktikDokterController::class, 'index_jadwal']);
    Route::get('dokter/jadwal_praktik/create/{id}', [JadwalPraktikDokterController::class, 'create']);
    Route::get('dokter/jadwal_praktik/update/{id}', [JadwalPraktikDokterController::class, 'updates']);
    Route::get('dokter/jadwal_praktik/hapus/{id}', [JadwalPraktikDokterController::class, 'destroy']);


    Route::post('sendchat',[KonsultasiPasienController::class,'sendChat']);
    Route::get('getchat/{id}',[KonsultasiPasienController::class,'getChat']);
