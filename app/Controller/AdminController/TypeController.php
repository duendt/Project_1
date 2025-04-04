<?php

namespace App\Controller\AdminController;

use App\Models\Brand;
use App\Models\Config as ModelsConfig;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\ProductType;
use App\Models\ProductVariant;
use PSpell\Config;

class TypeController
{
    
    public function create()
    {
        // return view('create');
    }
    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name'])) {
            die('Validation failed: Name is required.');
        }
        // Create product type
        ProductType::create($data);
        // Redirect to the product type list page
        header('Location: /admin/product-types');
        exit;
    }
}
