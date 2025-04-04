<?php
namespace App\Controller\AdminController;
use App\Models\Color;
class ColorController
{
    public function create()
    {
        // return view('create');
    }
    public function store()
    {
        $data = $_POST;
        // Validate data
        if (empty($data['name'])) {
            die('Validation failed: Name is required.');
        }
        // Create color
        Color::create($data);
        // Redirect to the color list page
        header('Location: /admin/colors');
        exit;
    }
    public function edit($id)
    {
        
    }
}