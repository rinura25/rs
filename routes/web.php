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
//organization
Route::get('/organization', 'OrganizationController@index_get');
Route::get('/organization_create', 'OrganizationController@index_create');
Route::post('/organization_create', 'OrganizationController@create_organization');

//location
Route::get('/location', 'LocationController@index_get');
Route::get('/location_create', 'LocationController@index_create');
Route::post('/location', 'LocationController@create_location');

//encoutner

Route::get('/encounter', 'EncounterController@index_get');
Route::get('/encounter_create', 'EncounterController@index_create');
Route::post('/encounter', 'EncounterController@create_encounter');

// Route::get('/index', 'EncounterController@index');