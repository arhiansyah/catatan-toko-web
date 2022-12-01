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
use Illuminate\Support\Facades\Storage;
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
            'store' => 'required',
            'day' => 'required'
        ]);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd($input);
        $input['total'] = str_replace("Rp.", "", $input['total']);
        $input['total'] = str_replace(" ", "", $input['total']);
        $input['total'] = str_replace(".", ",", $input['total']);
        $nf = new NumberFormatter("en_EN", NumberFormatter::DECIMAL);
        $input['total'] = $nf->parse($input['total'], NumberFormatter::TYPE_INT32);
        $input['store_id'] = $input['store'][0];
        $input['store'] = Store::find($input['store_id']);
        $input['store'] = $input['store']->name;
        //function file
        $image = $request->file('invoice');
        $imageName = date('YmdHis') . "." . $input['store'] . "." . $image->getClientOriginalExtension();
        $path =  date('Ymd') . '/' . $imageName;
        $image->storeAs(date('Ymd') . '/', $imageName, ['disk' => 'public']);
        //function total
        $input['invoice'] = $path;

        Transaction::create([
            'total' => $input['total'],
            'day' => $input['day'],
            'invoice' => $input['invoice'],
            'user_id' => Auth::user()->id,
            'store_id' => $input['store_id']
        ]);

        return redirect('/home')->with(['success' => 'Report Berhasil ditambahkan']);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        Storage::disk('public')->delete($transaction->invoice);
        $transaction->delete();
        return redirect()->back()->with(['success' => 'Delete Data Berhasil']);
    }
}
