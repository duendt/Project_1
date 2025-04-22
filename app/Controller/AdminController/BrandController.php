<?php

namespace App\Controller\AdminController;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariant;
class BrandController
{

    public function index()
    {
        $listBrand = Brand::all();
        return view('Admin.brands.index', compact('listBrand'));
    }
    public function create()
    {
        return view('Admin.brands.createbrand');
    }

    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name']) || empty($data['description'])) {
            $_SESSION['error'] = 'Các trường không được để trống!';
            return redirect('/admin/brands/create');
        } else {
            // Update product
            Brand::create($data);
            $_SESSION['message'] = 'Thêm dữ liệu thành công!';
            return redirect('/admin/brands/create');
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('Admin.brands.editbrand',compact(var_name: 'brand'));
    }

    public function update($id) {
        $data = $_POST;
        // Validate data
        if (empty($data['name']) || empty($data['description'])) {
            $_SESSION['error'] = 'Các trường không được để trống!';
            return redirect('/admin/brands/edit/'.$id);
        } else {
            // Update product
            Brand::update($data, $id);
            $_SESSION['message'] = 'Cập nhật dữ liệu thành công!';
            return redirect('/admin/brands/edit/'.$id);
        }
    }

    public function destroy($id)
    {
        $listProduct = Product::select('id_product')->where('id_brand', '=', $id)->get();

        // Kiểm tra nếu $listProduct có dữ liệu
        if (count($listProduct) > 0) {
            $_SESSION['error'] = 'Không thể xóa thương hiệu này vì có sản phẩm liên quan!';
            return redirect('/admin/brands');
        }

        // Xóa thương hiệu nếu không có sản phẩm liên quan
        Brand::delete($id);
        $_SESSION['confim'] = 'Xóa dữ liệu thành công!';
        return redirect('/admin/brands');
    }
}
