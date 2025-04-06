@extends('layouts.admin')
@section('title', 'Cập nhật cấu hình')

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
            <h6 class="m-0 font-weight-bold text-primary">Cập nhật cấu hình</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/configs/edit/' . $config->id_config }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cpu" class="form-label">CPU</label>
                            <input type="text" class="form-control" id="cpu" name="cpu" value="{{ $config->cpu }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ram" class="form-label">RAM</label>
                            <input type="text" class="form-control" id="ram" name="ram" value="{{ $config->ram }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gpu" class="form-label">GPU</label>
                            <input type="text" class="form-control" id="gpu" name="gpu" value="{{ $config->gpu }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="screen" class="form-label">Màn hình</label>
                            <input type="text" class="form-control" id="screen" name="screen" value="{{ $config->screen }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="battery" class="form-label">Pin</label>
                            <input type="text" class="form-control" id="battery" name="battery" value="{{ $config->battery }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="hz" class="form-label">Tần số quét</label>
                            <input type="text" class="form-control" id="hz" name="hz" value="{{ $config->hz }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="camera" class="form-label">Camera</label>
                            <input type="text" class="form-control" id="camera" name="camera" value="{{ $config->camera }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="operating_system" class="form-label">Hệ điều hành</label>
                            <input type="text" class="form-control" id="operating_system" name="operating_system" value="{{ $config->operating_system }}">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

@endsection