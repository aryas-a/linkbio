<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show homepage
     */
    public function home(): View
    {
        return view('pages.welcome');
    }

    /**
     * Show features page
     */
    public function features(): View
    {
        return view('pages.features');
    }

    /**
     * Show pricing page
     */
    public function pricing(): View
    {
        return view('pages.pricing');
    }

    /**
     * Show terms page
     */
    public function terms(): View
    {
        return view('pages.terms');
    }

    /**
     * Show privacy page
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
