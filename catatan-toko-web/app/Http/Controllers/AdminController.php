<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::where('user_id', Auth::user()->id)->first();
        $store_id = $admin->store[0]->id;
        $transaction = Transaction::select('day')
            ->where('store_id', $store_id)
            ->get();
        $dayDB = $transaction->groupBy(function ($data) {
            return Carbon::parse($data->day)->isoFormat('D');
        });
        // dd($dayDB);
        $monthDB = $transaction->groupBy(function ($data) {
            return Carbon::parse($data->day)->format('M');
        });
        $yearDB = $transaction->groupBy(function ($data) {
            return Carbon::parse($data->day)->format('Y');
        });
        $day = [];
        $month = [];
        $year = [];
        $countDay = [];
        $countMonth = [];
        $countYears = [];
        foreach ($dayDB as $key => $value) {
            $day[] = $key;
            $countDay[] = count($value);
        }
        foreach ($monthDB as $key => $value) {
            $month[] = $key;
            $countMonth[] = count($value);
        }
        foreach ($yearDB as $key => $value) {
            $year[] = $key;
            $countYears[] = count($value);
        }

        $admin24 = $admin->store[0]->transaction;
        foreach ($admin24 as $key => $value) {
            $admin24[$key]->total = number_format($value->total);
            $admin24[$key]->total = (string) $admin24[$key]->total;
        }
        // if (isset($admin->store)) {
        //     // $admin24 = $admin->store[0]->transaction;
        //     # code...
        // }
        // dd($admin);
        $data = [
            'admin' => $admin,
            'admin24' => $admin24,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'totalCountDay' => $countDay,
            'totalCountMonth' => $countMonth,
            'totalCountYear' => $countYears
        ];
        // dd($data);
        return view('pages/dashboard-admin', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
