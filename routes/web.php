<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PenerimaShtController;
use App\Http\Controllers\ShtController;
use App\Http\Controllers\RiwayatPenerimaController;
use App\Http\Controllers\SudahDibayarController;

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


Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/master', [MasterController::class, 'master'])->name('master');
    Route::get('/sht', [ShtController::class, 'search'])->name('sht');
    Route::get('/sht', [ShtController::class, 'sht'])->name('sht');
    Route::get('/shtlunas', [ShtController::class, 'showLunas'])->name('shtlunas');
    Route::get('/insertSht', [ShtController::class, 'tambahsht'])->name('insertSht');
    Route::post('/insertsht', [ShtController::class, 'insertsht'])->name('insertsht');
    Route::get('/shtDelete/{id}', [ShtController::class, 'shtDelete'])->name('shtDelete');
    Route::get('/editSht/{id}', [ShtController::class, 'editsht'])->name('editSht');
    Route::get('/searchSht', [ShtController::class, 'search'])->name('searchSht');
    Route::get('/sumindex', [ShtController::class, 'sumindex'])->name('sumindex');
    Route::get('/editSht/{id}', [ShtController::class, 'editSht'])->name('editSht');
    Route::put('/updatesht/{id}', [ShtController::class, 'updatesht'])->name('updatesht');
    Route::get('/viewSht/{id}', [ShtController::class, 'viewSht'])->name('viewSht');
    Route::get('/exportsht', [ShtController::class, 'shtexport'])->name('exportsht');
    Route::post('/importsht', [ShtController::class, 'shtimportexcel'])->name('importsht');
    Route::post('/update-data', [ShtController::class, 'updateData'])->name('updateData');
    Route::get('/sht/data', [ShtController::class, 'getData'])->name('sht.data');
    Route::get('/cetak-pdf', [ShtController::class, 'generatePdf'])->name('cetakPdf');

    // Penerima Sht
    // web.php
    Route::get('exportpenerimaSht', [PenerimaShtController::class, 'penerimaShtExport'])->name('penerimaShtExport');
    Route::get('/penerimasht', [PenerimaShtController::class, 'penerimasht'])->name('penerimasht');
    Route::get('/insertpenerimaSht', [PenerimaShtController::class, 'tambahpenerimaSht'])->name('insertpenerimaSht');
    Route::post('/insertpenerimaSht', [PenerimaShtController::class, 'insertpenerimaSht'])->name('insertpenerimaSht');

    Route::get('/penerimashtDelete/{no_penerima_sht}', [PenerimaShtController::class, 'penerimashtDelete'])->name('penerimashtDelete');

    Route::get('/searchpenerimaSht', [PenerimaShtController::class, 'search'])->name('searchpenerimaSht');
    Route::get('/sumindex', [PenerimaShtController::class, 'sumindex'])->name('sumindex');
    Route::get('/editpenerimaSht/{no_penerima_sht}', [PenerimaShtController::class, 'editpenerimaSht'])->name('editpenerimaSht');
    Route::put('/updatepenerimasht/{no_penerima_sht}', [PenerimaShtController::class, 'updatepenerimasht'])->name('updatepenerimasht');
    Route::get('/viewpenerimaSht/{no_penerima_sht}', [PenerimaShtController::class, 'viewpenerimaSht'])->name('viewpenerimaSht');

    Route::get('/riwayat-sht', [RiwayatPenerimaController::class, 'riwayatSht'])->name('riwayat-sht');
    Route::get('/riwayat', [PenerimaShtController::class, 'riwayat'])->name('riwayat');

    Route::put('/penerimaSht/update/{no_penerima_sht}', [RiwayatPenerimaController::class, 'update'])->name('updatepenerimaSht');



    Route::get('/exportpenerimaSht', [PenerimaShtController::class, 'penerimaShtexport'])->name('exportpenerimaSht');
    Route::post('/importpenerimaSht', [PenerimaShtController::class, 'penerima_shtimportexcel'])->name('importpenerimaSht');


    Route::get('/penerimaSht/data', [PenerimaShtController::class, 'getData'])->name('penerimaSht.data');

    Route::get('/cetak-pdf', [ShtController::class, 'generatePdf'])->name('cetakPdf');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/loginAdmin', [LoginController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::post('actionloginAdmin', [LoginController::class, 'actionloginAdmin'])->name('actionloginAdmin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');
