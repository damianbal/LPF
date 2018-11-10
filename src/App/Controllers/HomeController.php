<?php

namespace LPF\App\Controllers;

use LPF\Framework\Http\Request;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        return $this->html("Hello world!");
    }
}
