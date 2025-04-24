<?php

namespace App\Controller\AdminController;

use App\Models\ProductType;
use App\Models\Product;
use App\Models\ProductVariant;

class TypeController
{
    public function index()
    {
        $listType = ProductType::all();
        return view('admin.types.index', compact('listType'));
    }

    public function create()
    {
        return view('Admin.types.createtype');
    }

    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Tên loại sản phẩm không được để trống!';
            return redirect('admin/types/create');
        }
        $dataCheck = ProductType::select(['product_type.*'])
            ->where('name', '=', $data['name'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Loại sản phẩm đã tồn tại!';
            return redirect('admin/types/create');
        }

        ProductType::create($data);
        $_SESSION['message'] = 'Thêm loại sản phẩm thành công!';
        return redirect('admin/types/create');
    }

    public function edit($id)
    {
        $type = ProductType::find($id);
        return view('Admin.types.edittype', compact('type'));
    }

    public function update($id)
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Tên loại sản phẩm không được để trống!';
            return redirect('admin/types/edit/' . $id);
        }
        $dataCheck = ProductType::select(['product_type.*'])
            ->where('name', '=', $data['name'])
            ->andWhere('id_type', '!=', $id)
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Loại sản phẩm đã tồn tại!';
            return redirect('admin/types/edit/' . $id);
        }

        ProductType::update($data, $id);
        $_SESSION['message'] = 'Cập nhật loại sản phẩm thành công!';
        return redirect('admin/types/edit/' . $id);
    }

    public function destroy($id)
    {
        $listIdProduct = Product::select('id_product')->where('id_type', '=', $id)->get();
        if (count($listIdProduct) > 0) {
            $_SESSION['error'] = 'Không thể xóa loại sản phẩm này vì nó đang được sử dụng!';
            return redirect('admin/types');
        }
        ProductType::delete($id);
        $_SESSION['confim'] = 'Xóa loại sản phẩm thành công!';
        return redirect('admin/types');
    }
}
