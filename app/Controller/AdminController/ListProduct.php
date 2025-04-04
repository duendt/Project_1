<?php

namespace App\Controller\AdminController;

use App\Models\Config as ModelsConfig;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\ProductVariant;
use PSpell\Config;

class ListProduct
{
    public function index()
    {
        $listProduct = Product::select(['products.*', 'brand.name as brand_name'])
            ->join('brand', 'brand.id_brand', 'products.id_brand')
            ->get();
        //    dd($listProduct);
        return view('home');
    }
    public function productVariant($id)
    {
        $listVariant = ProductVariant::select(['product_variant.*'])
            ->where('id_product', '=', $id)
            ->get();
        dd($listVariant);
    }
    public function configVariant($id) {
        $configVariant = ProductConfig::select(['config_product.*'])
        ->where('id_config', '=', $id)
        ->get();
        dd($configVariant);
    }

    public function destroy($id){
        Product::delete($id);
    }

    public function create(){
        return view('create');
    }

    public function store(){
        $data = $_POST;



        // validate
        
        Product::create($data);
    }
}
