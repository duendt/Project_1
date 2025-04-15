<?php

namespace App\Controller\AdminController;

use App\Models\Color;
use App\Models\ProductVariant;

class ColorController
{
    public function index()
    {
        $listColor = Color::all();
        return view('Admin.colors.index', compact('listColor'));
    }

    public function create()
    {
        return view('Admin.colors.createcolor');
    }

    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Tên màu không được để trống!';
            return redirect('/admin/colors/create');
        } else {
            // Create color
            Color::create($data);
            $_SESSION['message'] = 'Thêm màu sắc thành công!';
            return redirect('/admin/colors/create');
        }
    }

    public function edit($id)
    {
        $color = Color::find($id);
        return view('Admin.colors.editcolor', compact('color'));
    }

    public function update($id)
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Tên màu không được để trống!';
            return redirect('/admin/colors/edit/' . $id);
        } else {
            // Update color
            Color::update($data, $id);
            $_SESSION['message'] = 'Cập nhật màu sắc thành công!';
            return redirect('/admin/colors/edit/' . $id);
        }
    }

    public function destroy($id)
    {
        $variants = ProductVariant::select(['product_variant.*'])
            ->where('id_color', '=', $id)
            ->get();
        if (count($variants) > 0) {
            $_SESSION['error'] = 'Không thể xóa màu sắc này vì nó đang được sử dụng trong các sản phẩm!';
            return redirect('admin/colors');
        }
        Color::delete($id);
        $_SESSION['confim'] = 'Xóa màu sắc thành công!';
        return redirect('/admin/colors');
    }
}
