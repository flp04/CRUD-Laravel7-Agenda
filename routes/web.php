<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', 'ContatoController@index');

Auth::routes();

Route::get('/home', 'ContatoController@index');

Route::get('/buscar', 'ContatoController@buscar');

Route::get('/criar-contato', 'ContatoController@formularioCriarContato')->middleware('auth');
Route::post('/criar-contato', 'ContatoController@criarContato');

Route::get('/editar-contato/{id}', 'ContatoController@formularioEditarContato');
Route::post('/editar-contato/{id}', 'ContatoController@editarContato');

Route::get('/excluir-contato/{id}', 'ContatoController@excluirContato');

Route::get('/mostrar-telefones/{id}', 'ContatoController@mostrarTelefones');