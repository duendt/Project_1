<?php
namespace App\Controller\AdminController;
use App\Models\User;
use App\Models\Role;
class UserController{
    public function index()
    {
        $listUser = User::all();
        return view('admin.users.index', compact('listUser'));
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