<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    /**
     * Display the About page.
     */
    public function index()
    {
        return view('about');
    }
}