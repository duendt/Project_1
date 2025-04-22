@extends('layouts.main')
@section('title', $news->title)
@section('content')
<div class="container my-5">
    <h1 class="mb-4">{{ $news->title }}</h1>
    <img src="{{ APP_URL . 'public/images/' . $news->image }}" class="img-fluid mb-4 vertical-image" alt="{{ $news->title }}" style="max-height: 500px; object-fit: cover;">
    <p class="text-muted">{{ $news->created_at }}</p>
    <div class="content">
        {!! $news->content !!}
    </div>
</div>
@endsection