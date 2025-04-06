@extends('layouts.admin')
@section('title', 'Thêm cấu hình mới')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/configs' }}" class="btn btn-primary">Quay lại</a>
    @if (isset($_SESSION['message']))
    <div class="alert alert-success">
        {{ $_SESSION['message'] }}
        @php unset($_SESSION['message']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm cấu hình mới</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/configs/create' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cpu" class="form-label">CPU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cpu" name="cpu" placeholder="VD: Apple A15 Bionic">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ram" class="form-label">RAM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ram" name="ram" placeholder="VD: 6GB LPDDR4X">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gpu" class="form-label">GPU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="gpu" name="gpu" placeholder="VD: Apple GPU 5-core">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="screen" class="form-label">Màn hình <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="screen" name="screen" placeholder="VD: 6.1 inch, Super Retina XDR">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="battery" class="form-label">Pin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="battery" name="battery" placeholder="VD: 3240 mAh, sạc nhanh 20W">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="hz" class="form-label">Tần số quét <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="hz" name="hz" placeholder="VD: 60 Hz">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="camera" class="form-label">Camera <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="camera" name="camera" placeholder="VD: Camera kép 12MP, 12MP">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="operating_system" class="form-label">Hệ điều hành <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="operating_system" name="operating_system" placeholder="VD: iOS 15">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
            </form>
        </div>
    </div>
</div>
@endsection