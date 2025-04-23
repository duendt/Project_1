@extends('layouts.main')
@section('title', 'Đăng nhập')
@section('content')
<div class="container my-5" style="background-color: #f8f9fa; border-radius: 15px; padding: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-gradient-primary text-center py-4" style="border-radius: 15px 15px 0 0;  color: black; font-weight: 500;">
                    <h4 class="mb-0">Đăng nhập</h4>
                </div>
                <div class="card-body p-5">
                    @if(isset($_SESSION['error']))
                    <div class="alert alert-danger">
                        {{ $_SESSION['error'] }}
                        @php unset($_SESSION['error']); @endphp
                    </div>
                    @endif
                    
                    @if(isset($_SESSION['success']))
                    <div class="alert alert-success">
                        {{ $_SESSION['success'] }}
                        @php unset($_SESSION['success']); @endphp
                    </div>
                    @endif
                    
                    <form action="{{ APP_URL . 'login' }}" method="POST">
                        <div class="mb-4">
                            <label for="username" class="form-label">Email hoặc Số điện thoại</label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Nhập email hoặc số điện thoại"  style="border-radius: 10px;">
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Nhập mật khẩu"  style="border-radius: 10px;">
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px;">Đăng nhập</button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p>Chưa có tài khoản? <a href="{{ APP_URL . 'register' }}" class="text-primary">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
