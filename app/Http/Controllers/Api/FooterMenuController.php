<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterMenu;
use Illuminate\Http\Request;

class FooterMenuController extends Controller
{
    public function index()
    {
        try
        {
            $footerMenu = FooterMenu::with('subFooterMenu')->limit('2')->get();

            return response()->json([
                'error' => false,
                'data' => $footerMenu
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching footer menu.'
            ], 500);
        }

    }
}
