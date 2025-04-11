<?php
namespace App\Controller\AdminController;
use App\Models\User;
use App\Models\Role;
class UserController{
    public function index()
    {
        $listUsers = User::all();
        return view('admin.users.index', compact('listUsers'));
    }

    public function create()
    {
        return view('admin.users.createuser');
    }

    public function store()
    {
        $data = $_POST;
        
        // Validate data
        $errors = [];
        
        // Kiểm tra tên
        if (empty($data['name'])) {
            $errors[] = 'Họ tên không được để trống!';
        } elseif (strlen($data['name']) > 100) {
            $errors[] = 'Họ tên không được vượt quá 100 ký tự!';
        }
        
        // Kiểm tra email
        if (empty($data['email'])) {
            $errors[] = 'Email không được để trống!';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không đúng định dạng!';
        } else {
            // Kiểm tra email đã tồn tại chưa
            $checkEmail = User::where('email', '=', $data['email'])->first();
            if ($checkEmail) {
                $errors[] = 'Email đã được sử dụng!';
            }
        }
        
        // Kiểm tra số điện thoại
        if (empty($data['phone'])) {
            $errors[] = 'Số điện thoại không được để trống!';
        } elseif (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors[] = 'Số điện thoại phải có 10 chữ số!';
        }else{
            $checkPhone = User::where('phone', '=', $data['phone'])->first();
            if ($checkPhone) {
                $errors[] = 'Số điện thoại đã được sử dụng!';
            }
        }
        
        // Kiểm tra địa chỉ
        if (empty($data['address'])) {
            $errors[] = 'Địa chỉ không được để trống!';
        }
        
        // Kiểm tra mật khẩu
        if (empty($data['password'])) {
            $errors[] = 'Mật khẩu không được để trống!';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự!';
        }
        
        // Kiểm tra vai trò
        if (!isset($data['role']) || ($data['role'] != '0' && $data['role'] != '1')) {
            $errors[] = 'Vai trò không hợp lệ!';
        }
        
        // Nếu có lỗi
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            return redirect('/admin/users/create');
        }
        
        // Mã hóa mật khẩu bằng md5
        $data['password'] = md5($data['password']);
        
        // Tạo người dùng mới
        User::create($data);
        $_SESSION['message'] = 'Thêm người dùng thành công!';
        return redirect('/admin/users/create');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edituser', compact('user'));
    }

    public function update($id)
    {
        $data = $_POST;
        // Validate data    
        // Validate data
        $errors = [];
        
        // Kiểm tra tên
        if (empty($data['name'])) {
            $errors[] = 'Họ tên không được để trống!';
        } elseif (strlen($data['name']) > 100) {
            $errors[] = 'Họ tên không được vượt quá 100 ký tự!';
        }
        
        // Kiểm tra email
        if (empty($data['email'])) {
            $errors[] = 'Email không được để trống!';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không đúng định dạng!';
        } else {
            // Kiểm tra email đã tồn tại chưa (không phải email hiện tại)
            $checkEmail = User::where('email', '=', $data['email'])->first();
            if ($checkEmail) {
                $errors[] = 'Email đã được sử dụng!';
            }
        }
        
        // Kiểm tra số điện thoại
        if (empty($data['phone'])) {
            $errors[] = 'Số điện thoại không được để trống!';
        } elseif (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors[] = 'Số điện thoại phải có 10 chữ số!';
        }else{
            $checkPhone = User::where('phone', '=', $data['phone'])->first();
            if ($checkPhone) {
                $errors[] = 'Số điện thoại đã được sử dụng!';
            }
        }
        
        // Kiểm tra địa chỉ
        if (empty($data['address'])) {
            $errors[] = 'Địa chỉ không được để trống!';
        }
        
        // Kiểm tra mật khẩu (nếu cập nhật)
        if (!empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự!';
            } else {
                // Mã hóa mật khẩu bằng md5
                $data['password'] = md5($data['password']);
            }
        } else {
            // Nếu không cập nhật mật khẩu, loại bỏ trường này khỏi data
            unset($data['password']);
        }
        // Nếu có lỗi
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            return redirect('/admin/users/edit/' . $id);
        }
        
        // Cập nhật thông tin người dùng
        User::update($data, $id);
        $_SESSION['message'] = 'Cập nhật thông tin người dùng thành công!';
        return redirect('/admin/users/edit/' . $id);
    }

    public function destroy($id)
    {
        User::delete($id);
        $_SESSION['confim'] = 'Xóa người dùng thành công!';
        return redirect('admin/users');
    }
}