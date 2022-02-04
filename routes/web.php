<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongsController;

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

Route::get('/song-lyrics', [SongsController::class, 'index'])->name('song.lyrics');
Route::post('/add-song',[SongsController::class,'addSong'])->name('add.song');
Route::get('/getSongLyrics',[SongsController::class, 'getSongLyrics'])->name('get.song.lyrics');
Route::post('/getSong',[SongsController::class, 'getSong'])->name('get.song');
Route::post('/saveSong',[SongsController::class, 'saveSong'])->name('save.song');
Route::post('/deleteSong',[SongsController::class,'deleteSong'])->name('delete.song');