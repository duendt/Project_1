<?php

namespace App\Controller\AdminController;

use App\Models\Storage;
use App\Models\ProductVariant;

class StorageController
{
    public function index()
    {
        $listStorage = Storage::all();
        return view('Admin.storages.index', compact('listStorage'));
    }
    public function create()
    {
        return view('admin.storages.createstorage');
    }

    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['storage'])) {
            $_SESSION['error'] = 'Dung lượng không được để trống!';
            return redirect('/admin/storages/create');
        }

        if (isset($data['unit'])) {
            $data['storage'] = $data['storage'] . ' ' . $data['unit'];
            unset($data['unit']); // Remove unit from data array
        }
        $dataCheck = Storage::select(['storage.*'])
            ->where('storage', '=', $data['storage'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Dung lượng đã tồn tại!';
            return redirect('/admin/storages/create');
        }

        // Create storage
        Storage::create($data);
        $_SESSION['message'] = 'Thêm dung lượng thành công!';
        return redirect('/admin/storages/create');
    }

    public function edit($id)
    {
        $storage = Storage::find($id);
        return view('admin.storages.editstorage', compact('storage'));
    }

    public function update($id)
    {
        $data = $_POST;
        // Validate data
        if (empty($data['storage'])) {
            $_SESSION['error'] = 'Dung lượng không được để trống!';
            return redirect('/admin/storages/edit/' . $id);
        }

        if (isset($data['unit'])) {
            $data['storage'] = $data['storage'] . ' ' . $data['unit'];
            unset($data['unit']);
        }
        $dataCheck = Storage::select(['storage.*'])
            ->where('storage', '=', $data['storage'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Dung lượng đã tồn tại!';
            return redirect('/admin/storages/edit/' . $id);
        }

        Storage::update($data, $id);
        $_SESSION['message'] = 'Cập nhật dung lượng thành công!';
        return redirect('/admin/storages/edit/' . $id);
    }

    public function destroy($id)
    {
        $variants = ProductVariant::select(['product_variant.*'])
            ->where('id_storage', '=', $id)
            ->get();
        if (count($variants) > 0) {
            $_SESSION['error'] = 'Không thể xóa dung lượng này vì nó đang được sử dụng trong các sản phẩm!';
            return redirect('/admin/storages');
        }
        Storage::delete($id);
        $_SESSION['confim'] = 'Xóa dung lượng thành công!';
        return redirect('/admin/storages');
    }
}
