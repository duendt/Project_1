<?php

namespace App\Controller\Auth;

use App\Models\User;

class AuthController
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            return redirect('');
        }

        return view('auth.login');
    }

    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validate input
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            return redirect('login');
        }

        // Check có phải email hay không
        $isEmail = filter_var($username, FILTER_VALIDATE_EMAIL);
        $user = null;
        if ($isEmail) {
            $user = User::select(['user.*'])
                ->where('email', '=', $username)
                ->first();
        } else {
            $user = User::where('phone', '=', $username)->first();
        }

        // Check password
        if ($user && $user->password === md5($password)) {

            $_SESSION['user_id'] = $user->id_user;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_role'] = $user->role;


            if ($user->role === 1) return redirect('admin');
            else return redirect('');
        }

        // Authentication failed
        $_SESSION['error'] = 'Email/SĐT hoặc mật khẩu không chính xác!';
        return redirect('login');
    }

    public function showRegisterForm()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            return redirect('');
        }
        return view('Auth.register');
    }

    public function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        // Validate input
        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($password_confirmation)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            return redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ!';
            return redirect('register');
        }

        if ($password !== $password_confirmation) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            return redirect('register');
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự!';
            return redirect('register');
        }

        // Check if email or phone already exists
        $existingUser = User::where('email', '=', $email)
            ->orWhere('phone', '=', $phone)
            ->first();

        if ($existingUser) {
            $_SESSION['error'] = 'Email hoặc số điện thoại đã được sử dụng!';
            return redirect('register');
        }

        // Create user
        User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'password' => md5($password), // Hash password
            'role' => 0, // Default role for regular users
        ]);

        $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        return redirect('login');
    }

    public function logout()
    {
        // Clear session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_role']);

        return redirect('');
    }
}
