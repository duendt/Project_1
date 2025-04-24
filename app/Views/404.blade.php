@extends('layouts.main')
@section('title', '404 Not Found')
@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4">404 Not Found</h1>
    <p class="lead">Xin lỗi, trang bạn tìm kiếm không tồn tại.</p>
    <a href="{{ APP_URL }}" class="btn btn-primary">Quay về trang chủ</a>
</div>
@endsection