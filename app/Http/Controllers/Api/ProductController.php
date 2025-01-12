<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
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

    public function categories()
    {
        try
        {
            $category = Category::where('is_enabled','1')
                            ->orderBy('order')->get();

            return response()->json([
                'error' => false,
                'data' => $category
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while category.'
            ], 500);
        } 
    }

    public function brands()
    {
        try
        {
            $brand = Brand::where('is_enabled','1')
                            ->orderBy('order')->get();

            return response()->json([
                'error' => false,
                'data' => $brand
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while brand.'
            ], 500);
        } 
    }

    public function tags()
    {
        try
        {
            $tag = Tag::where('is_enabled','1')
                            ->orderBy('order')->get();

            return response()->json([
                'error' => false,
                'data' => $tag
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while tag.'
            ], 500);
        } 
    }

    public function colors()
    {
        try
        {
            $color = Color::where('is_enabled','1')
                            ->orderBy('order')->get();

            return response()->json([
                'error' => false,
                'data' => $color
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while color.'
            ], 500);
        } 
    }

    public function products(Request $request)
    {
        try
        {
            $product = new Product();

            if($request->search != '')
            {
                $product = $product->where('name', 'like', '%' . $request->search . '%');
            }
            if($request->category != '')
            {
                $category = Category::where('name',$request->category)->first();
                $product = $product->where('category_id',$category->id);
            }

            if($request->color != '')
            {
                $color = Color::where('name',$request->color)->first();
                $product = $product->where('color_id',$color->id);
            }

            if($request->brand != '')
            {
                $brand = Brand::where('name',$request->brand)->first();
                $product = $product->where('brand_id',$brand->id);
            }

            if($request->tag != '')
            {
                $tag = Tag::where('name',$request->tag)->first();
                $productId = ProductHasTag::where('tag_id',$tag->id)->get()->pluck('product_id');
                $product = $product->whereIn('id',$productId);
            }

            if($request->price != '')
            {
                if(strpos($request->price,'-') !== false)
                {
                    $exploded = explode("-",$request->price);
                    $product = $product->whereBetween('price',[(int)$exploded[0],(int)$exploded[1]]);
                }
                else
                {
                    $exploded = explode("+",$request->price);
                    $product = $product->where('price','>=',(int)$exploded[0]);
                }
            }

            if($request->priceFilter == "Low")
            {
                $product = $product->orderByRaw("CAST(price AS UNSIGNED) ASC");
            }
            else $product = $product->orderByRaw("CAST(price AS UNSIGNED) DESC");

            $product = $product->paginate(12,['*'],'page',$request->page ?? 1);

            return response()->json([
                'error' => false,
                'data' => $product
            ], 200);
        }
        catch(\Exception $ex)
        {
            dd($ex);
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while products.'
            ], 500);
        } 
    }
}
