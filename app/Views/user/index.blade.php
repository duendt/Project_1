@extends('layouts.main')
@section('title', 'Thông tin người dùng')
@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h3 class="mb-0">Thông tin người dùng</h3>
        </div>
        <div class="card-body">
            <form action="{{ APP_URL . 'user/update' }}" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Họ tên:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" >
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label">Địa chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" >
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0">Đổi mật khẩu</h3>
        </div>
        <div class="card-body">
            <form action="{{ APP_URL . 'user/change-password' }}" method="POST">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại:</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" >
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="new_password" class="form-label">Mật khẩu mới:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" >
                    </div>
                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" >
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection