<?php
namespace App\Controller;
use App\Models\News;
use App\Models\News as ModelsNews;

class NewsController
{
    public function index()
    {
        $newsList = News::all();
        return view('news.index', compact('newsList'));
    }

    public function detail($id)
    {
        $news = News::find($id);
        if (!$news) {
            $_SESSION['error'] = 'Bài viết không tồn tại!';
            return redirect('news');
        }
        return view('news.detail', compact('news'));
    }
}