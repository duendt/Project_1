@extends('layouts.main')
@section('title', 'Tin tức')
@section('content')
<div class="container my-5">
    <h1 class="mb-4">Tin tức</h1>
    <div class="row">
    @foreach ($newsList as $article)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ APP_URL . 'public/images/' . $article->image }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text mb-4">
                            @if (!empty($article->content))
                                {{ mb_substr($article->content, 0, 150, 'UTF-8') }}
                                @if (mb_strlen($article->content, 'UTF-8') > 150)
                                    ...
                                @endif
                            @else
                                <em>Không có nội dung</em>
                            @endif
                        </p>
                        <p class="text-muted mt-auto">
                            <small>Ngày đăng: 
                                @if (!empty($article->created_at))
                                    {{ date('d/m/Y', strtotime($article->created_at)) }}
                                @else
                                    Không xác định
                                @endif
                            </small>
                        </p>
                        <a href="{{ APP_URL . 'news/' . $article->id }}" class="btn btn-primary mt-2">Đọc thêm</a>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
</div>
@endsection