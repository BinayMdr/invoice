<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaleProduct;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{
    public function index()
    {
        try
        {
            $saleProduct = SaleProduct::where('is_enabled',1)->first();

            if(!is_null($saleProduct))
            {
                $offerTillLastDate = Carbon::parse($saleProduct->offer_till_date);

                $currentTime = new DateTime();
                $currentTime->setTimezone(new DateTimeZone('Asia/Kathmandu'));
                $currentTimeInNepal = Carbon::parse($currentTime);

                if($offerTillLastDate < $currentTimeInNepal) $saleProduct = null;
            }
            return response()->json([
                'error' => false,
                'data' => $saleProduct
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching saleproduct.'
            ], 500);
        }

    }
}
