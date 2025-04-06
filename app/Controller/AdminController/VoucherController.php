<?php
namespace App\Controller\AdminController;
use App\Models\Voucher;
class VoucherController{
    public function index()
    {
        $listVoucher = Voucher::all();
        return view('admin.vouchers.index', compact('listVoucher'));
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