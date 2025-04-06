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
        } else {
            // Format storage value with unit
            if (isset($data['unit'])) {
                $data['storage'] = $data['storage'] . ' ' . $data['unit'];
                unset($data['unit']); // Remove unit from data array
            }
            
            // Create storage
            Storage::create($data);
            $_SESSION['message'] = 'Thêm dung lượng thành công!';
            return redirect('/admin/storages/create');
        }
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
            return redirect('/admin/storages/edit/'.$id);
        } else {
            // Format storage value with unit
            if (isset($data['unit'])) {
                $data['storage'] = $data['storage'] . ' ' . $data['unit'];
                unset($data['unit']); // Remove unit from data array
            }
            
            // Update storage
            Storage::update($data, $id);
            $_SESSION['message'] = 'Cập nhật dung lượng thành công!';
            return redirect('/admin/storages/edit/'.$id);
        }
    }

    public function destroy($id)
    {
        ProductVariant::deleteByStorageId($id);
        Storage::delete($id);
        $_SESSION['confim'] = 'Xóa dung lượng thành công!';
        return redirect('/admin/storages');
    }
}
