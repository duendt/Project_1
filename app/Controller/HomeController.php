<?php

namespace App\Controller;

use App\Models\Product;

class HomeController{
    public function index(){
        $products = Product::select(['products.*','brand.name as brand_name'])
        ->join('brand','brand.id_brand','products.id_brand')
        ->get();
        return view('home',compact('products'));
    }
}