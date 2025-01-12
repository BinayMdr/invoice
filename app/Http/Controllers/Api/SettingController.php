<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        try
        {
            $settings = Setting::select('key','value')->get();

            return response()->json([
                'error' => false,
                'data' => $settings
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching settings.'
            ], 500);
        }

    }
}
