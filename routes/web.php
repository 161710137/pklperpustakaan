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
Route::get('myform/ajax/{id}','PinjamkblController@myformAjax');
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
Route::get('hapus', 'BukuController@destroy')->name('hapus');
Route::post('/buku/edit/{id}', 'BukuController@update');
Route::get('buku/getedit/{id}', 'BukuController@edit');
//anggota
Route::resource('anggota', 'AnggotaController');
Route::get('anggota_json', 'AnggotaController@json')->name('anggota');
Route::post('anggotas', 'AnggotaController@store');
Route::get('hilang', 'AnggotaController@removedata')->name('hilang');
Route::post('/anggota/edit/{id_jb}', 'AnggotaController@update');
Route::get('anggota/getedit/{id_jb}', 'AnggotaController@edit');
//pinjam
Route::resource('pinjam', 'PinjamkblController');
Route::get('pinjam_json', 'PinjamkblController@json')->name('pinjam');
Route::post('pinjams', 'PinjamkblController@store');
Route::post('/pinjam/edit/{id}', 'PinjamkblController@update');
Route::get('pinjam/getedit/{id}', 'PinjamkblController@edit');
//kembali
Route::get('kembali', 'PinjamkblController@indexkembali');
Route::get('kembali/json', 'PinjamkblController@json_kbl');
Route::post('kembalis', 'PinjamkblController@store');
Route::post('/kembali/edit/{id}', 'PinjamkblController@updatekembali');
Route::get('kembali/getedit/{id}', 'PinjamkblController@edit');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
