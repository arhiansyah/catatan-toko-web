<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->hasRole('guest')) {
            $store = Store::all();
            $data = [
                'store' => $store
            ];
            return view('home', $data);
        } else if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.index');
        } else if (Auth::user()->hasRole('super-admin')) {
            return redirect()->route('superAdmin');
        }
    }
}
