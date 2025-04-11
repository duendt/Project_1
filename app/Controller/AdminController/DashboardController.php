<?php
namespace App\Controller\AdminController;
use App\Models\Product;
class DashboardController
{
    public function index()
    {
        return view('Admin.dashboard.index');
    }
}

