@extends('layouts.main')
@section('title', 'Đăng ký')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đăng ký tài khoản</h4>
                </div>
                <div class="card-body">
                    @if(isset($_SESSION['error']))
                    <div class="alert alert-danger">
                        {{ $_SESSION['error'] }}
                        @php unset($_SESSION['error']); @endphp
                    </div>
                    @endif
                    
                    <form action="{{ APP_URL . 'dang-ky' }}" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                            <small class="form-text text-muted">Mật khẩu phải có ít nhất 8 ký tự</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Tôi đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">điều khoản sử dụng</a></label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <p>Đã có tài khoản? <a href="{{ APP_URL . 'dang-nhap' }}">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Điều khoản sử dụng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Điều khoản sử dụng</h6>
                <p>Bằng việc đăng ký và sử dụng TechStore, bạn đồng ý tuân thủ các điều khoản và điều kiện sau đây.</p>
                
                <h6>2. Thông tin cá nhân</h6>
                <p>Chúng tôi cam kết bảo mật các thông tin cá nhân của bạn. Thông tin của bạn sẽ không được chia sẻ với bất kỳ bên thứ ba nào mà không có sự đồng ý của bạn.</p>
                
                <h6>3. Tài khoản của bạn</h6>
                <p>Bạn chịu trách nhiệm về việc duy trì tính bảo mật của tài khoản và mật khẩu. TechStore không chịu trách nhiệm cho bất kỳ tổn thất nào phát sinh từ việc không tuân thủ quy định bảo mật này.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection
