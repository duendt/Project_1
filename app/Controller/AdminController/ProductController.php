<?php

namespace App\Controller\AdminController;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Config as ModelsConfig;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\ProductType;
use App\Models\ProductVariant;
use App\Models\Storage;
use PSpell\Config;

class ProductController
{
    public function index()
    {
        $listProduct = Product::select(['products.*', 'brand.name as brand_name'])
            ->join('brand', 'brand.id_brand', 'products.id_brand')
            ->get();
        $listType = ProductType::all();
        $listBrand = Brand::all();
        $listColor = Color::all();
        $listConfig = ProductConfig::all();
        $listStorage = Storage::all();
        //    dd($listProduct);
        return view(
            'Admin.products.index',
            compact('listProduct', 'listType', 'listBrand', 'listColor', 'listConfig', 'listStorage')
        );
    }
    public function productVariant($id)
    {
        $listVariant = ProductVariant::select(['product_variant.*'])
            ->where('id_product', '=', $id)
            ->get();
        dd($listVariant);
    }
    public function configVariant($id)
    {
        $configVariant = ProductConfig::select(['config_product.*'])
            ->where('id_config', '=', $id)
            ->get();
        dd($configVariant);
    }

    public function destroy($id)
    {
        Product::delete($id);
    }

    public function create()
    {
        // return view('create');
    }

    public function store()
    {
        $data = $_POST;

        // Validate data
        if (empty($data['name']) || empty($data['id_brand']) || empty($data['description'])) {
            die('Validation failed: Name, Brand, and Description are required.');
        }

        // Create product
        Product::create($data);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $listType = ProductType::all();
        // return view('Admin.products.index', compact('product', 'listType'));
    }


    public function update($id)
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name']) || empty($data['id_brand']) || empty($data['description'])) {
            die('Validation failed: Name, Brand, and Description are required.');
        }

        // Update product
        Product::update($data, $id);
        return redirect('/admin/products/index');
    }
}
