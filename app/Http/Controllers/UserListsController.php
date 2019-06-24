<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserListsController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index',[
            'users' => $users
        ]);
    }
}
