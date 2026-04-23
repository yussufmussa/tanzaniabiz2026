<?php

namespace App\Http\Controllers\Backend\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\BusinessListing;
use Illuminate\Http\Request;

class BusinessDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

      $BusinessListings = BusinessListing::where('user_id', $userId)
                                    ->get();


        $noOfBusinessListings = $BusinessListings->count();

        // Count active, inactive, and total BusinessListings
        $activeBusinessListingCount = $BusinessListings->where('status',1)->count();
        $inactiveBusinessListingCount = $BusinessListings->where('status',0)->count();
        $totalBusinessListingCount = $BusinessListings->count();

        $listing = $BusinessListings->first();

        return view('frontend.business_owner.dashboard', compact(
            'activeBusinessListingCount',
            'totalBusinessListingCount',
            'inactiveBusinessListingCount',
            'noOfBusinessListings',
            'listing'
        ));
    }
}
