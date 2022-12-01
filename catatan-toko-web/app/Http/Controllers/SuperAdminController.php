<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $user = User::create([
            'name' => 'Admin ' . strtolower(Str::slug($input['store'])),
            'email' => 'admin' . strtolower(Str::slug($input['store'])) . '@example.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole(['role' => 'admin']);
        $input['user_id'] = $user->id;
        $admin = Admin::create([
            'name' => 'Admin ' . $input['store'],
            'user_id' => $input['user_id']
        ]);
        $input['admin_id'] = $admin->id;
        $store = Store::create([
            'name' => $input['store'],
            'admin_id' => (int) $input['admin_id']
        ]);

        return redirect()->route('superAdmin')->with(['success' => 'Success add new admin store']);
    }

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
