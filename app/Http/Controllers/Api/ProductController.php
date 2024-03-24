<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductHasTag;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function details($slug)
    {
        try
        {
            $product = Product::where('slug',$slug)->first();

            return response()->json([
                'error' => false,
                'data' => $product
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching product.'
            ], 500);
        }

    }

    public function related_products($slug)
    {
        try
        {
            $product = Product::where('slug',$slug)->first();

            $filterProduct = Setting::where('key','related-product')->first();

            $relatedProducts = [];
            if($filterProduct->value == "Brand")
            {
                $relatedProducts = Product::whereNotIn('id',[$product->id])
                                    ->where('category_id',$product->brand_id)
                                    ->where('is_enabled','1')
                                    ->limit(4)->get();
            }
            else if($filterProduct->value == "Category")
            {
                $relatedProducts = Product::whereNotIn('id',[$product->id])
                                    ->where('category_id',$product->category_id)
                                    ->where('is_enabled','1')
                                    ->limit(4)->get();
            }
            else
            {
                $tags = ProductHasTag::where('product_id',$product->id)->get()->pluck('tag_id');
                $relatedProductId = ProductHasTag::whereNotIn('product_id',[$product->id])
                                                    ->whereIn('tag_id',$tags)
                                                    ->get()->pluck('product_id');
                
                $relatedProducts = Product::whereIn('id',$relatedProductId)
                                                ->where('is_enabled','1')
                                                ->orderBy('created_at','desc')
                                                ->limit(4)
                                                ->get();
            }

            return response()->json([
                'error' => false,
                'data' => $relatedProducts
            ], 200);
        }
        catch(\Exception $ex)
        {
            dd($ex);
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching product.'
            ], 500);
        }

    }
}
