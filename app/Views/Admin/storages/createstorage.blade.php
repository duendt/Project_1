@extends('layouts.admin')
@section('title', 'Thêm dung lượng lưu trữ mới')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/storages' }}" class="btn btn-primary">Quay lại</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Thêm dung lượng lưu trữ mới</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/storages/create' }}">
                <div class="mb-3">
                    <label for="storage" class="form-label">Dung lượng <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="storage" name="storage" min="1">
                        <select class="form-select" id="unit" name="unit">
                            <option value="GB">GB</option>
                            <option value="TB">TB</option>
                        </select>
                    </div>
                    <small class="text-muted">Ví dụ: 128 GB, 256 GB, 512 GB, 1 TB, ...</small>
                </div>
                <button type="submit" class="btn btn-primary">Lưu dung lượng</button>
            </form>
        </div>
    </div>
</div>
@endsection