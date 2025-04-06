<?php
namespace App\Controller\AdminController;
use App\Models\Order;
use App\Models\OrderDetail;
class OrderController{
    public function index()
    {
        $listOrder = Order::all();
        return view('admin.orders.index', compact('listOrder'));
    }

    public function create()
    {
        
    }

    public function store()
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update($id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}