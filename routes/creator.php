<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CreatorController;
Route::group(['prefix' => 'creator/{slug}/dashboard' , 'middleware' =>  ['auth:creators' ,'creator']] , function () {

    Route::get('/' , [CreatorController::class , 'index'])->name('creator.dashboard');
    Route::get('/show/{exam_slug}' , [CreatorController::class , 'show'])->name('creator.dashboard.show');
    Route::get('/create' , [CreatorController::class , 'create'])->name('creator.dashboard.create');
    Route::post('/store' , [CreatorController::class , 'store'])->name('creator.dashboard.store');
    Route::post('/enable_disable_access/{exam_slug}' , [CreatorController::class , 'changeAccess'])->name('creator.dashboard.enable_disable_access');
    Route::post('/destroy' , [CreatorController::class , 'destroy'])->name('creator.dashboard.destroy');
    Route::post('/exam/approve/{exam_slug}' , [\App\Http\Controllers\Dashboard\PreviewController::class , 'approve'])->name('dashboard.creator.approve');
    Route::post('/exam/disapprove/{exam_slug}' , [\App\Http\Controllers\Dashboard\PreviewController::class , 'disapprove'])->name('dashboard.creator.disapprove');;
    Route::match(['get' , 'post'] , '/requests/{exam_id?}/{user_id?}'  ,\App\Http\Controllers\Dashboard\Creator\RequestController::class )->name('dashboard.creator.requests');

});


