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

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            return redirect('');
        }

        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        // Validate input
        if (empty($name) || empty($email) || empty($phone) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            return redirect('/dang-ky');
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ!';
            return redirect('/dang-ky');
        }

        // Validate phone
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            $_SESSION['error'] = 'Số điện thoại không hợp lệ!';
            return redirect('/dang-ky');
        }

        // Check if passwords match
        if ($password !== $password_confirmation) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            return redirect('/dang-ky');
        }

        // Check if email already exists
        if (User::where('email', '=', $email)->exists()) {
            $_SESSION['error'] = 'Email đã được sử dụng!';
            return redirect('/dang-ky');
        }

        // Check if phone already exists
        if (User::where('phone', '=', $phone)->exists()) {
            $_SESSION['error'] = 'Số điện thoại đã được sử dụng!';
            return redirect('/dang-ky');
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create user
        $userData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
            'role' => 'customer', // Default role
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userId = User::create($userData);

        if ($userId) {
            // Set flash message
            $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            return redirect('/dang-nhap');
        } else {
            $_SESSION['error'] = 'Đăng ký thất bại! Vui lòng thử lại sau.';
            return redirect('/dang-ky');
        }
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
