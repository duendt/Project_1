<?php
namespace App\Controller\AdminController;

use App\Models\News;

class NewsController
{
    public function index()
    {
        $listNews = News::all();
        return view('admin.news.index', compact('listNews'));
    }

    public function create()
    {
        return view('admin.news.createnews');
    }

    public function store()
    {
        $data = $_POST;

        // Validate data
        $errors = [];

        // Kiểm tra tiêu đề
        if (empty($data['title'])) {
            $errors[] = 'Tiêu đề không được để trống!';
        }

        // Kiểm tra nội dung
        if (empty($data['content'])) {
            $errors[] = 'Nội dung không được để trống!';
        }

        // Kiểm tra hình ảnh
        if (empty($_FILES['image']['name'])) {
            $errors[] = 'Hình ảnh không được để trống!';
        } else {
            $target_dir = ROOT_DIR . "/public/images/";
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            // Kiểm tra loại file
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($file_extension), $allowed_types)) {
                $errors[] = 'Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF)!';
            } elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $errors[] = 'Không thể upload ảnh!';
            } else {
                $data['image'] = $new_filename;
            }
        }

        // Nếu có lỗi
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            return redirect('/admin/news/create');
        }

        // Tạo tin tức mới
        News::create($data);
        $_SESSION['message'] = 'Thêm tin tức thành công!';
        return redirect('/admin/news/create');
    }

    public function edit($id)
    {
        $news = News::find($id);
        return view('admin.news.editnews', compact('news'));
    }

    public function update($id)
    {
        $data = $_POST;

        // Validate data
        $errors = [];

        // Kiểm tra tiêu đề
        if (empty($data['title'])) {
            $errors[] = 'Tiêu đề không được để trống!';
        }

        // Kiểm tra nội dung
        if (empty($data['content'])) {
            $errors[] = 'Nội dung không được để trống!';
        }

        // Kiểm tra hình ảnh (nếu cập nhật)
        if (!empty($_FILES['image']['name'])) {
            $target_dir = ROOT_DIR . "/public/images/";
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            // Kiểm tra loại file
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($file_extension), $allowed_types)) {
                $errors[] = 'Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF)!';
            } elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $errors[] = 'Không thể upload ảnh!';
            } else {
                $data['image'] = $new_filename;

                // Xóa ảnh cũ nếu có
                $news = News::find($id);
                if ($news && !empty($news->image)) {
                    $old_image_path = ROOT_DIR . "/public/images/" . $news->image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
        }

        // Nếu có lỗi
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            return redirect('/admin/news/edit/' . $id);
        }

        // Cập nhật tin tức
        News::update($data, $id);
        $_SESSION['message'] = 'Cập nhật tin tức thành công!';
        return redirect('/admin/news/edit/' . $id);
    }

    public function destroy($id)
    {
        // Xóa tin tức
        News::delete($id);
        $_SESSION['message'] = 'Xóa tin tức thành công!';
        return redirect('/admin/news');
    }
}