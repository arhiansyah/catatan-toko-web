<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $store = Store::all();
        $data = [
            'store' => $store
        ];
        return view('home', $data);
    }
}
