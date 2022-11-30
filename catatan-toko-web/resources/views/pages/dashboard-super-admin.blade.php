@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @foreach ($admin as $item)
            <div class="card mb-4">
                <div class="card-header">Report {{ $item->name }} </div>
                <div class="card-body">
                    <h3>Report Penjualan Harian</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Index</th>
                                    <th>Total Penjualan</th>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->store[0]->transaction as $key => $tr)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $tr->total }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tr->day)->isoFormat('D-M-Y') }}</td>
                                    <td><a href="{!! route('showimage', $tr->invoice) !!}">{{ $tr->invoice
                                            }}</a></td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="" class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
