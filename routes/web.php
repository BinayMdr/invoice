<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SaleProductController;
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
Route::match(['get','post'],'/',[AuthController::class,'login'])->name('login');

Route::group(['middleware'=>'auth'],function(){
    Route::get('/dashboard',[PageController::class,'dashboard'])->name('dashboard');
    Route::get('/profile',[PageController::class,'profile'])->name('profile');
    Route::post('/update-password',[ProfileController::class,'update_password'])->name('update.password');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');

    Route::get('/setting',[SettingController::class,'index'])->name('setting');
    Route::put('/setting/update',[SettingController::class,'update'])->name('update.setting');

    Route::get('/user',[UserController::class,'index'])->name('user');
    Route::get('/user/create',[UserController::class,'create'])->name('create.user');
    Route::post('/user',[UserController::class,'store'])->name('store.user');
    Route::get('/user/edit/{user}',[UserController::class,'edit'])->name('edit.user');
    Route::put('/user/update/{user}',[UserController::class,'update'])->name('update.user');

    Route::get('/payment-method',[PaymentController::class,'index'])->name('payment-method');
    Route::get('/payment-method/create',[PaymentController::class,'create'])->name('create.payment-method');
    Route::post('/payment-method',[PaymentController::class,'store'])->name('store.payment-method');
    Route::get('/payment-method/edit/{paymentMethod}',[PaymentController::class,'edit'])->name('edit.payment-method');
    Route::put('/payment-method/update/{paymentMethod}',[PaymentController::class,'update'])->name('update.payment-method');

    Route::get('/group',[GroupController::class,'index'])->name('group');
    Route::get('/group/create',[GroupController::class,'create'])->name('create.group');
    Route::post('/group',[GroupController::class,'store'])->name('store.group');
    Route::get('/group/edit/{group}',[GroupController::class,'edit'])->name('edit.group');
    Route::put('/group/update/{group}',[GroupController::class,'update'])->name('update.group');

    Route::get('/banner',[BannerController::class,'index'])->name('banner');
    Route::get('/banner/create',[BannerController::class,'create'])->name('create.banner');
    Route::get('/banner/edit/{banner}',[BannerController::class,'edit'])->name('edit.banner');

    Route::get('/sale-product',[SaleProductController::class,'index'])->name('sale-product');
    Route::get('/sale-product/create',[SaleProductController::class,'create'])->name('create.sale-product');
    Route::get('/sale-product/edit/{saleProduct}',[SaleProductController::class,'edit'])->name('edit.sale-product');
});