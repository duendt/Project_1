<?php
namespace App\Controller\AdminController;

use App\Models\Brand;
use App\Models\Config as ModelsConfig;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\ProductType;
use App\Models\ProductVariant;
use PSpell\Config;

class BrandController
{
   

    public function create()
    {
        
    }

    public function store()
    {
        $data = $_POST;

        // Validate data
        if (empty($data['name'])) {
            die('Validation failed: Name is required.');
        }

        // Create brand
        Brand::create($data);

        // Redirect to the brand list page
        header('Location: /admin/brands');
        exit;
    }
}