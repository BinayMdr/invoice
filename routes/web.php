<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FilterProductController;
use App\Http\Controllers\FilterTagController;
use App\Http\Controllers\FooterMenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PopUpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleProductController;
use App\Http\Controllers\TagController;
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

    Route::get('/user',[UserController::class,'index'])->name('user');
    Route::get('/user/create',[UserController::class,'create'])->name('create.user');
    Route::get('/user/delete/{user}',[UserController::class,'destroy'])->name('delete.user');
    Route::post('/user',[UserController::class,'store'])->name('store.user');
    Route::get('/user/edit/{user}',[UserController::class,'edit'])->name('edit.user');
    Route::put('/user/update/{user}',[UserController::class,'update'])->name('update.user');


    Route::get('/group',[GroupController::class,'index'])->name('group');
    Route::get('/group/create',[GroupController::class,'create'])->name('create.group');
    Route::get('/group/delete/{group}',[GroupController::class,'destroy'])->name('delete.group');
    Route::post('/group',[GroupController::class,'store'])->name('store.group');
    Route::get('/group/edit/{group}',[GroupController::class,'edit'])->name('edit.group');
    Route::put('/group/update/{group}',[GroupController::class,'update'])->name('update.group');

    Route::get('/banner',[BannerController::class,'index'])->name('banner');
    Route::get('/banner/create',[BannerController::class,'create'])->name('create.banner');
    Route::get('/banner/delete/{banner}',[BannerController::class,'destroy'])->name('delete.banner');
    Route::get('/banner/edit/{banner}',[BannerController::class,'edit'])->name('edit.banner');
 

    Route::get('/about-us',[AboutUsController::class,'index'])->name('about-us');


    Route::get('/pop-up',[PopUpController::class,'index'])->name('pop-up');
    Route::get('/pop-up/create',[PopUpController::class,'create'])->name('create.pop-up');
    Route::get('/pop-up/delete/{popUp}',[PopUpController::class,'destroy'])->name('delete.pop-up');
    Route::get('/pop-up/edit/{popUp}',[PopUpController::class,'edit'])->name('edit.pop-up');

    Route::get('/product',[ProductController::class,'index'])->name('product');
    Route::get('/product/create',[ProductController::class,'create'])->name('create.product');
    Route::get('/product/edit/{product}',[ProductController::class,'edit'])->name('edit.product');

});