<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\FilterProduct;
use App\Models\FilterTag;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;

class FilterTagController extends Controller
{
    public function index()
    {
        try
        {
            $setting = Setting::get()->pluck('value','key');

            $filterTags = FilterTag::orderBy('order')->limit($setting['filter-tag'])->get();

            $data = [];
            foreach ($filterTags as $filterTag) {
                $tag = Tag::find($filterTag->tag_id);
                
                $products = FilterProduct::where('tag_id', $filterTag->tag_id)
                                          ->orderBy('order')
                                          ->limit($setting['filter-product'])
                                          ->get();
            
                $productDetails = Product::whereIn('id', $products->pluck('product_id'))->where('is_enabled','1')->get()->keyBy('id');
            
                $data[] = [
                    'tag' => $tag,
                    'products' => $products->map(function ($product) use ($productDetails) {
                        return $productDetails[$product->product_id];
                    }),
                ];
            }
            

            return response()->json([
                'error' => false,
                'data' => $data
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' =>  'An error occurred while fetching filter tag.'
            ], 500);
        }

    }
}
