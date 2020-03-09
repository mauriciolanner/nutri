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
    return view('auth.login');
});

Auth::routes();

//rotas de inicio
Route::get('/home', 'CustomerController@index')->name('home');

//rotas clientes
Route::get('/clientes', 'CustomerController@index')->name('clientes');
Route::get('/deletaclientes/{id}', 'CustomerController@delet')->name('deletaclientes');
Route::post('/novocliente', 'CustomerController@create')->name('novocliente');
Route::post('/editacliente', 'CustomerController@update')->name('editacliente');

//rotas endereços
Route::get('/deletaend/{id}', 'AddressController@delet')->name('deletaend');
Route::get('/tornaprincipal/{id}/{cliente}', 'AddressController@tornarPrincipal')->name('tornaprincipal');
Route::get('/perfil/{cliente}', 'AddressController@index')->name('enderecos');
Route::post('/novoendereco', 'AddressController@create')->name('novoendereco');
Route::post('/editarendereco', 'AddressController@update')->name('editarendereco');
