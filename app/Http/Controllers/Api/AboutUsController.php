<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        try
        {
            $aboutUs = AboutUs::first();

            return response()->json([
                'error' => false,
                'data' => $aboutUs
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching about us.'
            ], 500);
        }

    }
}
