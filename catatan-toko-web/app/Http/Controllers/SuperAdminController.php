<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    public function index()
    {
        $admin = Admin::all();
        foreach ($admin as $key => $value) {
            foreach ($value->store[0]->transaction as $tkey => $tr) {
                $result = number_format($tr->total);
                $admin[$key]->store[0]->transaction[$tkey]->total = (string) $result;
            }
        }
        $data = [
            'admin' => $admin,
        ];
        // dd($data);

        return view('pages/dashboard-super-admin', $data);
    }

    public function download($file)
    {
        // dd($file);
        return Storage::download($file);
    }
}
