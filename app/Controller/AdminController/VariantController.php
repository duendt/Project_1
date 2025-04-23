<?php

namespace App\Controller\AdminController;

use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Storage;
use App\Models\Color;
use App\Models\ProductConfig;

class VariantController
{
    public function index()
    {
        $listVariant = ProductVariant::select([
            'product_variant.*',
            'products.name as product_name',
            'color.name as color',
            'storage.storage',
            'config_product.*'
        ])
            ->join('products', 'products.id_product', 'product_variant.id_product')
            ->join('color', 'color.id_color', 'product_variant.id_color')
            ->join('storage', 'storage.id_storage', 'product_variant.id_storage')
            ->join('config_product', 'config_product.id_config', 'product_variant.id_config')
            ->get();
        $listProduct = Product::all();
        $listStorage = Storage::all();
        return view('admin.variants.index', compact('listVariant','listProduct','listStorage'));
    }

    public function create() 
    {
        $listProduct = Product::all();
        $listColor = Color::all();
        $listStorage = Storage::all();
        $listConfig = ProductConfig::all();
        return view('admin.variants.createvariant', compact('listProduct', 'listColor', 'listStorage', 'listConfig'));
    }

    public function store() 
    {
        $data = $_POST;
        
        // Validate data
        if (empty($data['id_product']) || empty($data['id_color']) || empty($data['id_storage']) || 
            empty($data['id_config']) || empty($data['price']) || empty($data['quantity'])) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            return redirect('admin/variants/create');
        }
        $dataCheck = ProductVariant::select(['product_variant.*'])
            ->where('id_product', '=', $data['id_product'])
            ->where('id_color', '=', $data['id_color'])
            ->where('id_storage', '=', $data['id_storage'])
            ->where('id_config', '=', $data['id_config'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Phiên bản sản phẩm đã tồn tại!';
            return redirect('admin/variants/create');
        }
        
        // Xử lý upload ảnh
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = ROOT_DIR . "/public/images/";
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Kiểm tra loại file
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array(strtolower($file_extension), $allowed_types)) {
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF)!';
                return redirect('admin/variants/create');
            }
            
            // Upload file
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $data['image'] = $new_filename;
            } else {
                $_SESSION['error'] = 'Không thể upload ảnh!';
                return redirect('admin/variants/create');
            }
        } else {
            $_SESSION['error'] = 'Vui lòng chọn ảnh cho phiên bản sản phẩm!';
            return redirect('admin/variants/create');
        }
        
        // Create variant
        ProductVariant::create($data);
        $_SESSION['message'] = 'Thêm phiên bản sản phẩm thành công!';
        return redirect('admin/variants');
    }

    public function edit($id) 
    {
        $variant = ProductVariant::find($id);
        if (!$variant) {
            $_SESSION['error'] = 'Không tìm thấy phiên bản sản phẩm!';
            return redirect('admin/variants');
        }
        
        $listProduct = Product::all();
        $listColor = Color::all();
        $listStorage = Storage::all();
        $listConfig = ProductConfig::all();
        
        return view('admin.variants.editvariant', compact('variant', 'listProduct', 'listColor', 'listStorage', 'listConfig'));
    }

    public function update($id) 
    {
        $data = $_POST;
        
        // Validate data
        if (empty($data['id_product']) || empty($data['id_color']) || empty($data['id_storage']) || 
            empty($data['id_config']) || empty($data['price']) || empty($data['quantity'])) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            return redirect('admin/variants/edit/' . $id);
        }
        $dataCheck = ProductVariant::select(['product_variant.*'])
            ->where('id_product', '=', $data['id_product'])
            ->where('id_color', '=', $data['id_color'])
            ->where('id_storage', '=', $data['id_storage'])
            ->where('id_config', '=', $data['id_config'])
            ->get();
        if (count($dataCheck) > 0) {
            $_SESSION['error'] = 'Phiên bản sản phẩm đã tồn tại!';
            return redirect('admin/variants/edit/' . $id);
        }
        
        // Xử lý upload ảnh nếu có
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = ROOT_DIR . "/public/images/";
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Kiểm tra loại file
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array(strtolower($file_extension), $allowed_types)) {
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF)!';
                return redirect('admin/variants/edit/' . $id);
            }
            
            // Upload file
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $data['image'] = $new_filename;
                
                // Xóa ảnh cũ nếu có
                $variant = ProductVariant::find($id);
                if ($variant && !empty($variant->image)) {
                    $old_image_path = ROOT_DIR . "/public/images/" . $variant->image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            } else {
                $_SESSION['error'] = 'Không thể upload ảnh!';
                return redirect('admin/variants/edit/' . $id);
            }
        }
        
        // Update variant
        ProductVariant::update($data, $id);
        $_SESSION['message'] = 'Cập nhật phiên bản sản phẩm thành công!';
        return redirect('admin/variants/edit/' . $id);
    }

    public function destroy($id) 
    {
        // Tìm phiên bản trước khi xóa để lấy thông tin về ảnh
        $variant = ProductVariant::find($id);
        $orderDetails = ProductVariant::select(['order_details.*'])
            ->where('id_prodvar','=', $id)
            ->get();
        if (count($orderDetails) > 0) {
            $_SESSION['error'] = 'Không thể xóa phiên bản sản phẩm này vì nó đã được đặt hàng!';
            return redirect('admin/variants');
        }
        if ($variant && !empty($variant->image)) {
            $image_path = ROOT_DIR . "/public/images/" . $variant->image;
            if (file_exists($image_path)) {
                unlink($image_path); // Xóa file ảnh
            }
        }
        
        // Xóa bản ghi
        ProductVariant::delete($id);
        $_SESSION['confim'] = 'Xóa phiên bản sản phẩm thành công!';
        return redirect('admin/variants');
    }
}
