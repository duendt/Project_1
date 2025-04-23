<?php

namespace App\Controller\ClientController;

use App\Models\User;

class UserController
{
    public function index()
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            return redirect('login');
        }
        $user = User::find($_SESSION['user_id']);
        return view('user.index', compact('user'));
    }

    public function update()
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            return redirect('login');
        }

        $data = $_POST;
        $errors = [];

        // Validate name
        if (empty($data['name'])) {
            $errors[] = 'Họ tên không được để trống!';
        } elseif (strlen($data['name']) > 100) {
            $errors[] = 'Họ tên không được vượt quá 100 ký tự!';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors[] = 'Email không được để trống!';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không đúng định dạng!';
        } else {
            $checkEmail = User::where('email', '=', $data['email'])
                ->andWhere('id_user', '!=', $_SESSION['user_id'])
                ->first();
            if ($checkEmail) {
                $errors[] = 'Email đã được sử dụng bởi tài khoản khác!';
            }
        }

        // Validate phone
        if (empty($data['phone'])) {
            $errors[] = 'Số điện thoại không được để trống!';
        } elseif (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors[] = 'Số điện thoại phải có 10 chữ số!';
        } else {
            $checkPhone = User::where('phone', '=', $data['phone'])
                ->andWhere('id_user', '!=', $_SESSION['user_id'])
                ->first();
            if ($checkPhone) {
                $errors[] = 'Số điện thoại đã được sử dụng bởi tài khoản khác!';
            }
        }

        // Validate address
        if (empty($data['address'])) {
            $errors[] = 'Địa chỉ không được để trống!';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(", ", $errors);
            return redirect('user/profile');
        }

        User::update($data, $_SESSION['user_id']);

        $_SESSION['success'] = 'Cập nhật thông tin thành công!';
        return redirect('user/profile');
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            return redirect('login');
        }

        $data = $_POST;
        $errors = [];

        $user = User::find($_SESSION['user_id']);
        if (md5($data['current_password']) !== $user->password) {
            $errors[] = 'Mật khẩu hiện tại không đúng!';
        }

        if (empty($data['new_password'])) {
            $errors[] = 'Mật khẩu mới không được để trống!';
        } elseif (strlen($data['new_password']) < 6) {
            $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
        }

        if ($data['new_password'] !== $data['confirm_password']) {
            $errors[] = 'Xác nhận mật khẩu mới không khớp!';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(", ", $errors);
            return redirect('user/profile');
        }

        // Update password
        $updateData = ['password' => md5($data['new_password'])];
        User::update($updateData, $_SESSION['user_id']);

        $_SESSION['success'] = 'Đổi mật khẩu thành công!';
        return redirect('user/profile');
    }
}
