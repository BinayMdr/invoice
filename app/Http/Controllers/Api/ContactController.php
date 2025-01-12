<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        try
        {
            $contact = Contact::first();

            return response()->json([
                'error' => false,
                'data' => $contact
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching contact.'
            ], 500);
        }

    }
}
