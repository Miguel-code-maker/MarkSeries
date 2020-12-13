<?php

use App\Http\Controllers\EpisodiosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TemporadasController;
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
    return redirect()->route('login');
});

Route::get('/series', [SeriesController::class, 'index'])->name('series');

Route::get('/series/adicionar', [SeriesController::class, 'create'])->name('series.adicionar');

Route::post('/series/adicionar', [SeriesController::class, 'store'])->name('series.adicionarDo');

Route::delete('/series/remover/{id}', [SeriesController::class, 'destroy'])->name('series.removeDo');

Route::post('/series/{serieId}/editar', [SeriesController::class, 'updateName'])->name('series.editarDo');

Route::get('/series/{serieId}/temporadas', [TemporadasController::class, 'index'])->name('series.temporadas');

Route::post('/series/temporada/adicionar', [TemporadasController::class, 'addTemp'])->name('series.temporada.adicionarDo');

Route::post('/series/temporada/remover', [TemporadasController::class, 'removerTemp'])->name('series.temporada.removerDo');

Route::post('/series/{temporada}/episodio/assistir', [EpisodiosController::class, 'watch'])->name('series.temporada.episodio.assistirDo');

Route::post('/series/temporada/episodio/adicionar', [EpisodiosController::class, 'adicionar'])->name('series.temporada.episodio.adicionarDo');

Route::post('/series/temporada/episodio/remover', [EpisodiosController::class, 'destroy'])->name('series.temporada.episodio.removerDo');

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class , 'login'])->name('loginDo');

Route::get('/registrar', [RegisterController::class, 'index'])->name('register');

Route::post('/registrar', [RegisterController::class, 'register'])->name('registerDo');

Route::get('/logout', function() {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect()->route('login');
});
