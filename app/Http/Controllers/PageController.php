<?php

namespace App\Http\Controllers;

use App\Pages;

class PageController extends Controller
{
    public function __invoke($page)
    {
        switch ($page) {
            case 'about': $data = Pages::find(1); break;
            case 'privacy': $data = Pages::find(2); break;
            case 'terms': $data = Pages::find(3); break;
            case 'help': $data = Pages::find(4); break;
            default: $data = Pages::find(4); break;
        }
        return view('pages.master')->with('data', $data);
    }
}
