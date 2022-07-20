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

Route::get('/', function () {
    return redirect('/series');
});

// Route::resource('/series', \App\Http\Controllers\SeriesController::class); // Pode ser usado se seguir o padrão de rotas;


// passando rotas padrão
Route::resource('/series', \App\Http\Controllers\SeriesController::class)
    ->only(['index','create','store','delete', 'edit']);

/*
 Criando função que cria grupo de rotas
Route::controller(\App\Http\Controllers\SeriesController::class)->group(function (){
    Route::get('/series', 'index')->name('series.index');
    Route::get('/series/criar','create')->name('series.create'); // lembrar de colocar {{route(series.create)}} na view
    Route::post('/series/salvar', 'store')->name('series.store');
} );

*/

Route::post('/series/destroy/{series}', [\App\Http\Controllers\SeriesController::class, 'destroy'])->name('series.destroy');
// sempre que houver uma rota com parametro, conseguimos buscar esse parâmetro simplesmente tendo
// um parametro de mesmo nome no método e o tipo facilita para o laravel entender com tratar;


