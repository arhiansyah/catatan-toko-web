@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form action="{{ route('superAdmin.store') }}" method="POST">
                @csrf
                <div class="input-group mb-3" x-data="{ open: false}">
                    <a class="btn btn-secondary btn-md me-2" x-on:click="open = ! open">Add
                        New
                        Store</a>
                    <div x-show="open" class="me-3" x-cloak>
                        <div class="d-flex justify-content-center">
                            <input type="text" class="w-full form-control bg-light me-4 ms-4" name="store"
                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                placeholder="Input your name store">
                            <button type="submit" class="btn btn-primary btn-md">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
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
                                        <form action="{{ route('delete.store', $tr->id) }}" class="d-inline"
                                            method="POST">
                                            @csrf @method("DELETE")
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>

                                        </form>
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
