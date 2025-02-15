<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-customer-reviews')) return back();
        return view('pages.customer-review.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-customer-reviews')) return back();
        $customerReview = null;
        return view('pages.customer-review.edit-create',compact('customerReview'));
    }

    public function edit(CustomerReview $customerReview)
    {
        if(!\Auth::user()->hasRole('edit-customer-reviews')) return back();
        return view('pages.customer-review.edit-create',compact('customerReview'));
    }

    public function destroy(CustomerReview $customerReview)
    {
        if(\Auth::user()->hasRole('delete-customer-reviews'))
        {
            $customerReview->delete();
            return redirect()->route('customer-review')->with('success','Customer Review deleted');
        }
        return back();
    }

}
