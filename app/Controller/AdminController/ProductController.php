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


    // product:
    public function create()
    {
        $listBrand = Brand::all();
        $listType = ProductType::all();
        return view('Admin.products.createproduct', compact('listBrand', 'listType'));
    }

    public function store()
    {
        $data = $_POST;

        // Validate data
        if (empty($data['name']) || empty($data['warranty']) || empty($data['description'])) {
            $_SESSION['error'] = 'Các trường không được để trống!';
            return redirect('/admin/products/create');
        }
        $dataCheck = Product::select(['products.*'])
            ->where('name', '=', $data['name'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Tên sản phẩm đã tồn tại!';
            return redirect('/admin/products/create');
        }

        Product::create($data);
        $_SESSION['message'] = 'Thêm sản phẩm thành công!';
        return redirect('/admin/products/create');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::all();
        $listType = ProductType::all();
        return view('Admin.products.editproduct', data: compact('product', 'listType', 'brands'));
    }
    public function update($id)
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name']) || empty($data['id_brand']) || empty($data['description'])) {
            $_SESSION['error'] = 'Các trường không được để trống!';
            return redirect('/admin/products/edit/' . $id);
        }
        $dataCheck = Product::select(['products.*'])
            ->where('name', '=', $data['name'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Tên sản phẩm đã tồn tại!';
            return redirect('/admin/products/edit/' . $id);
        }

        Product::update($data, $id);
        $_SESSION['message'] = 'Cập nhật dữ liệu thành công!';
        return redirect('/admin/products/edit/' . $id);
    }
    public function destroy($id)
    {
        $variants = ProductVariant::select(['product_variant.*'])
            ->where('id_product', '=', $id)
            ->get();
        if (count($variants) > 0) {
            $_SESSION['error'] = 'Không thể xóa sản phẩm này vì nó có các biến thể liên quan!';
            return redirect('admin/products');
        }
        Product::delete((int)$id);
        $_SESSION['confim'] = 'Xóa sản phẩm thành công!';
        return redirect('/admin/products');
    }

    // 
}
