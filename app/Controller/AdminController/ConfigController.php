<?php
namespace App\Controller\AdminController;

use App\Models\ProductConfig;
use App\Models\ProductVariant;
class ConfigController
{
    public function index()
    {
        $listConfig = ProductConfig::all();
        return view('admin.configs.index', compact('listConfig'));
    }

    public function create()
    {
        return view('admin.configs.createconfig');
    }

    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['cpu']) || empty($data['ram']) || empty($data['screen']) || 
            empty($data['battery']) || empty($data['camera']) || empty($data['operating_system'])) {
            $_SESSION['error'] = 'Các trường bắt buộc không được để trống!';
            return redirect('/admin/configs/create');
        } else {
            // Create config
            ProductConfig::create($data);
            $_SESSION['message'] = 'Thêm cấu hình thành công!';
            return redirect('/admin/configs/create');
        }
    }

    public function edit($id)
    {
        $config = ProductConfig::find($id);
        return view('admin.configs.editconfig', compact('config'));
    }

    public function update($id)
    {
        $data = $_POST;
        // Validate data
        if (empty($data['cpu']) || empty($data['ram']) || empty($data['gpu']) || empty($data['screen']) || 
            empty($data['battery']) || empty($data['hz']) || empty($data['camera']) || empty($data['operating_system'])) {
            $_SESSION['error'] = 'Các trường bắt buộc không được để trống!';
            return redirect('/admin/configs/edit/'.$id);
        } else {
            // Update config
            ProductConfig::update($data, $id);
            $_SESSION['message'] = 'Cập nhật cấu hình thành công!';
            return redirect('/admin/configs/edit/'.$id);
        }
    }

    public function destroy($id)
    {
        ProductVariant::deleteByConfigId($id);
        ProductConfig::delete($id);
        $_SESSION['confim'] = 'Xóa cấu hình thành công!';
        return redirect('/admin/configs');
    }
}
