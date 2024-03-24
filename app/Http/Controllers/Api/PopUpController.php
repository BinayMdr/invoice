<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\PopUp;
use Illuminate\Http\Request;

class PopUpController extends Controller
{
    public function index()
    {
        try
        {
            $popup = PopUp::where('is_enabled','1')->first();

            return response()->json([
                'error' => false,
                'data' => $popup
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching popup.'
            ], 500);
        }

    }
}
