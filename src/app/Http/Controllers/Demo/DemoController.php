<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('about');
    }

    /**
     * @return Application|Factory|View
     */
    public function contact()
    {
        return view('contact');
    }
}
