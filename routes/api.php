<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FilterTagController;
use App\Http\Controllers\Api\FooterMenuController;
use App\Http\Controllers\Api\PopUpController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/settings',[SettingController::class,'index']);
Route::get('/contact',[ContactController::class,'index']);
Route::get('/about-us',[AboutUsController::class,'index']);
Route::get('/footer-menu',[FooterMenuController::class,'index']);
Route::get('/banner',[BannerController::class,'index']);
Route::get('/mid-banners',[BannerController::class,'midBanners']);
Route::get('/sale-product',[SaleProductController::class,'index']);
Route::get('/filter-tag',[FilterTagController::class,'index']);
Route::get('/pop-up',[PopUpController::class,'index']);
Route::get('/product-detail/{slug}',[ProductController::class,'details']);
Route::get('/related-products/{slug}',[ProductController::class,'related_products']);
Route::get('/categories',[ProductController::class,'categories']);
Route::get('/colors',[ProductController::class,'colors']);
Route::get('/tags',[ProductController::class,'tags']);
Route::get('/brands',[ProductController::class,'brands']);
Route::get('/products',[ProductController::class,'products']);