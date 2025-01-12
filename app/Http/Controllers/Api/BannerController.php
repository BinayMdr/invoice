<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        try
        {
            $banner = Banner::where('banner_type','Main Banner')->first();

            return response()->json([
                'error' => false,
                'data' => $banner
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching banner.'
            ], 500);
        }

    }

    public function midBanners()
    {
        try
        {
            $banners = Banner::where('banner_type','Mid Banner')->where('is_enabled',1)->get();

            return response()->json([
                'error' => false,
                'data' => $banners
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching mid banners.'
            ], 500);
        }

    }
}
