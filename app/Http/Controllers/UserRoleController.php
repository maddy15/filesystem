<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelperClass\Helping;

class UserRoleController extends Controller
{
    public $helping;

    public function __construct(Helping $helping)
    {
        $this->helping = $helping;
    }

    public function index()
    {
        // $root = get_class($this->helping);
        // var_dump($root);
        return $this->helping->item('sadwasda');
    }
}
