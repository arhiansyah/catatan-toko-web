<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use NumberFormatter;

class StoreController extends Controller
{
    public function index()
    {
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'invoice' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf',
            'total' => 'required',
        ]);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['total'] = str_replace("Rp.", "", $input['total']);
        $input['total'] = str_replace(" ", "", $input['total']);
        $input['total'] = str_replace(".", ",", $input['total']);
        $nf = new NumberFormatter("en_EN", NumberFormatter::DECIMAL);
        $input['total'] = $nf->parse($input['total'], NumberFormatter::TYPE_INT32);
        if ($input['store'] != null) {
            $user = User::create([
                'name' => 'Admin ' . Auth::user()->name,
                'email' => 'admin' . strtolower(Str::slug($input['store'])),
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
            $input['store_id'] = $store->id;
        } else {
            $input['store_id'] = $input['storeArray'][0];
            $input['store'] = $input['store_id'];
            $input['store'] = Store::find($input['store']);
            $input['store'] = $input['store']->name;
        }
        // dd($input['store_id']);

        //function file
        $image = $request->file('invoice');
        $imageName = date('YmdHis') . "." . $input['store'] . "." . $image->getClientOriginalExtension();
        $path =  date('Ymd') . '/' . $imageName;
        $image->storeAs(date('Ymd') . '/', $imageName, ['disk' => 'public']);
        //function total
        $input['invoice'] = $path;

        $input['day'] = Carbon::now();

        Transaction::create([
            'total' => $input['total'],
            'day' => $input['day'],
            'invoice' => $input['invoice'],
            'user_id' => Auth::user()->id,
            'store_id' => $input['store_id']
        ]);

        return redirect('/home')->with(['success' => 'Report Berhasil ditambahkan']);
    }
}
