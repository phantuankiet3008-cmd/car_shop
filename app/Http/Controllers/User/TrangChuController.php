<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\QL;

class TrangChuController extends Controller
{
    public function index()
    {
        return view('user.layouts.user_index');
    }
    public function trangchu()
    {
        return view('user.partials.user_trangchu');
    }
}

?>