<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $data = [];
        // Best selling
        $data['best_selling'] = Product::bestSelling()->get();

        // Featured Product
        $data['featured'] = Product::featured()->get();

        // Recently Viewed Product
        $data['recently_viewed'] = Product::recentlyViewed()->get();

        return view('frontend.index')->with($data);
    }
}
