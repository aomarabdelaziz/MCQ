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
    return view('welcome');
});




Route::middleware(['verified' , 'auth'])->group(function () {


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'exam'] , function () {


        Route::group(['prefix' => 'scoreboard'] , function () {
            Route::get('/' , [\App\Http\Controllers\Dashboard\User\ScoreBoardController::class , 'index'])->name('user.exam.scoreboards');
            Route::get('/{exam_slug}' , [\App\Http\Controllers\Dashboard\User\ScoreBoardController::class , 'show'])->name('user.exam.scoreboard');
        });
        Route::get('/{exam_slug}' , \App\Http\Livewire\McqExam::class);

        Route::get('/participate/{exam_slug}' , \App\Http\Livewire\McqExam::class)->name('user.exam.participate');



    });


});




Auth::routes(['verify' => true]);
Auth::routes();
