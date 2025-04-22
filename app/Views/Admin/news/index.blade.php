@extends('layouts.admin')
@section('title', 'Quản lý tin tức')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý tin tức</h2>
        <a href="{{ APP_URL . 'admin/news/create'}}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm tin tức
        </a>
    </div>
    <!-- Danh sách tin tức -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Hình ảnh</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listNews as $news)
                        <tr>
                            <td>{{ $news->id }}</td>
                            <td>{{ $news->title }}</td>
                            <td><img src="{{ APP_URL . 'public/images/'. $news->image }}" alt="Image" width="60px"></td>
                            <td>{{ $news->created_at }}</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/news/edit/' . $news->id }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ APP_URL . 'admin/news/delete/' . $news->id }}" method="post">
                                    <button class="btn btn-danger btn-icon-split" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Xóa</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection