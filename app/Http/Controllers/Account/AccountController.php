<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\Helping;

class AccountController extends Controller
{
    public function index()
    {
        // return Helping::upStr('asd');
        return view('account.index');
    }
}
