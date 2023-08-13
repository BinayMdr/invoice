<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GlobalSettingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

    Route::get('/branch',[BranchController::class,'index'])->name('branch');
    Route::get('/branch/create',[BranchController::class,'create'])->name('create.branch');
    Route::post('/branch',[BranchController::class,'store'])->name('store.branch');
    Route::get('/branch/edit/{branch}',[BranchController::class,'edit'])->name('edit.branch');
    Route::put('/branch/update/{branch}',[BranchController::class,'update'])->name('update.branch');

    Route::get('/product',[ProductController::class,'index'])->name('product');
    Route::get('/product/create',[ProductController::class,'create'])->name('create.product');
    Route::post('/product',[ProductController::class,'store'])->name('store.product');
    Route::get('/product/edit/{product}',[ProductController::class,'edit'])->name('edit.product');
    Route::put('/product/update/{product}',[ProductController::class,'update'])->name('update.product');

    Route::get('/setting',[SettingController::class,'index'])->name('setting');
    Route::put('/setting/update',[SettingController::class,'update'])->name('update.setting');

    Route::get('/customer',[CustomerController::class,'index'])->name('customer');
    Route::get('/customer/create',[CustomerController::class,'create'])->name('create.customer');
    Route::post('/customer',[CustomerController::class,'store'])->name('store.customer');
    Route::get('/customer/edit/{customer}',[CustomerController::class,'edit'])->name('edit.customer');
    Route::put('/customer/update/{customer}',[CustomerController::class,'update'])->name('update.customer');

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

    Route::get('/invoice',[InvoiceController::class,'index'])->name('invoice');
    Route::get('/invoice/create',[InvoiceController::class,'create'])->name('create.invoice');
    Route::post('/invoice',[InvoiceController::class,'store'])->name('store.invoice');
    Route::get('/invoice/edit/{invoice}',[InvoiceController::class,'edit'])->name('edit.invoice');
    Route::put('/invoice/update/{invoice}',[InvoiceController::class,'update'])->name('update.invoice');
    Route::get('/invoice/delete/{invoice}',[InvoiceController::class,'delete'])->name('delete.invoice');
    Route::get('print-invoice/{invoiceId}',[InvoiceController::class,'download'])->name('download.invoice');

    Route::get('/global-setting',[GlobalSettingController::class,'index'])->name('global-setting');
    Route::put('/globa-setting/update',[GlobalSettingController::class,'update'])->name('update.global-setting');
});