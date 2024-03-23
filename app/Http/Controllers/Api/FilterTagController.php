<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\FilterProduct;
use App\Models\FilterTag;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class FilterTagController extends Controller
{
    public function index()
    {
        try
        {
            $filterTags = FilterTag::orderBy('order')->limit(3)->get();

            $data = [];
            foreach ($filterTags as $filterTag) {
                $tag = Tag::find($filterTag->tag_id);
                
                $products = FilterProduct::where('tag_id', $filterTag->tag_id)
                                          ->orderBy('order')
                                          ->limit(8)
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
                'message' => $ex
            ], 500);
        }

    }
}
