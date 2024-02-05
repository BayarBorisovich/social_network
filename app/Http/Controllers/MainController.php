<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller
{
    public function getForm(): View
    {
        return view('main');
    }
}
