<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class CustomerBackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('customerbackend.index');
    }
}
