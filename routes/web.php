<?php

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

Route::get('/status', 'TokenController@get_token');
// Route::get('/pasien', 'PasienController@index');
Route::get('/pasien', 'PasienController@index');
// Route::post('/pasien', 'PasienController@index');
Route::get('/dokter', 'DokterController@dokter_nik');
// Route::get('/medication', 'MedicationController@index');
Route::get('/medication', 'MedicationController@index');
Route::post('/medication', 'MedicationController@index');
Route::get('/cari', 'PasienController@cari');
Route::get('/cari', 'DokterController@cari');
Route::get('/dokter', 'DokterController@index');