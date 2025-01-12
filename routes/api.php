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
