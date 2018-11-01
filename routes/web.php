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
//jnbuku
Route::resource('jnbuku', 'JnBukuController');
Route::get('jnbuku_json', 'JnBukuController@json')->name('jnbuku');
Route::post('jnbukus', 'JnBukuController@store');
Route::get('delete', 'JnBukuController@removedata')->name('delete');
Route::post('/jnbuku/edit/{id_jb}', 'JnBukuController@update');
Route::get('jnbuku/getedit/{id_jb}', 'JnBukuController@edit');
//buku
Route::resource('buku', 'BukuController');
Route::get('buku_json', 'BukuController@json')->name('buku');
Route::post('bukus', 'BukuController@store');
Route::get('hapus', 'BukuController@removedata')->name('hapus');
Route::post('/buku/edit/{id_buku}', 'BukuController@update');
Route::get('buku/getedit/{id_buku}', 'BukuController@edit');
//anggota
Route::resource('anggota', 'AnggotaController');
Route::get('anggota_json', 'AnggotaController@json')->name('anggota');
Route::post('anggotas', 'AnggotaController@store');
Route::get('delete', 'AnggotaController@removedata')->name('delete');
Route::post('/anggota/edit/{id_jb}', 'AnggotaController@update');
Route::get('anggota/getedit/{id_jb}', 'AnggotaController@edit');
//pinjam
Route::resource('pinjam', 'PinjamkblController');
Route::get('pinjam_json', 'PinjamkblController@json')->name('pinjam');
Route::post('pinjams', 'PinjamkblController@store');
Route::get('hapus', 'PinjamkblController@removedata')->name('hapus');
Route::post('/pinjam/edit/{id_buku}', 'PinjamkblController@update');
Route::get('pinjam/getedit/{id_buku}', 'PinjamkblController@edit');