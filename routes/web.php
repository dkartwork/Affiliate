<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AlreadyLogin;
use App\Http\Middleware\AuthCheck;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/products',[ProductController::class,'AllProducts'])->middleware(AuthCheck::class);
Route::get('/buy',[ProductController::class,'BuyProduct'])->middleware(AuthCheck::class);
Route::controller(AuthenController::class)->group(function(){
    Route::get('/registration','registration')->middleware(AlreadyLogin::class);
    Route::get('/login','login')->middleware(AlreadyLogin::class);
    Route::get('/dashboard','dashboard')->middleware(AuthCheck::class);
    Route::get('/logout','logout');

    Route::post('/register-user','registrationUser')->name('register');
    Route::post('/login-user','loginUser')->name('login');
});
