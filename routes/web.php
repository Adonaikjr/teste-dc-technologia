<?php

use App\Http\Controllers\ControllerClientes;
use App\Http\Controllers\ControllerItemsCarrinho;
use App\Http\Controllers\ControllerProdutos;
use App\Http\Controllers\ControllerVendas;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerCategoria;
use App\Http\Controllers\ControllerCorretores;
use App\Http\Controllers\ControllerImoveis;
use App\Http\Controllers\ControllerLeads;
use App\Http\Controllers\ControllerProprietario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//USUARIO ROOOT
Route::controller(Controller::class)->group(function () {
    Route::get('/criar-user', 'index')->name('index');
    Route::post('/criar-user', 'criar')->name('criar-user');
    Route::get('/', 'login')->name('login');
    Route::post('/autenticarLogin', 'autenticarLogin')->name('autenticarLogin');
    Route::get('/logout', 'logout')->name('logout');
});


//USUARIOS ROOOT AUTENTICADO!
Route::middleware('usuarios')->group(function () {

    Route::controller(ControllerVendas::class)->group(function () {
        Route::get('/vendas', 'index')->name('vendas');
        Route::post('/vendas/criar', 'criar')->name('criar-venda');
        Route::get('/vendas/lista', 'lista')->name('lista-venda');
        Route::get('/vendas/{vendaId}', 'dadosVenda')->name('dados-venda');
        Route::delete('/vendas/{vendaId}', 'deletar')->name('deletar-venda');

    });

    Route::controller(ControllerClientes::class)->group(function () {
        Route::get('/buscar', 'buscar')->name('buscar');
        Route::post('/criar-cliente', 'create')->name('criar-cliente');
    });

    Route::controller(ControllerProdutos::class)->group(function () {
        Route::get('/buscar-produto', 'buscar')->name('buscarProduto');
        Route::post('/criar-produto', 'criar')->name('criar-produto');

    });

});
