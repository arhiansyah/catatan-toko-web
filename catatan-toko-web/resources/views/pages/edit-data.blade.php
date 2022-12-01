@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Edit Data</h4>
                    <form action="" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name Store</label>
                            <div class="input-group" x-data="{ open: false, show: true }">
                                <a class="btn btn-secondary btn-lg  me-2" x-on:click="open = ! open, hide()">Add
                                    New
                                    Store</a>
                                <div x-show="open" class="me-3" x-cloak>
                                    <input type="text" class="w-full form-control form-control-lg" name="store"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Input your name store">
                                </div>
                                <select name="storeArray[]" id="storeArrayID" class="form-select form-select-lg">
                                    <option value="" selected>Choose any store you want</option>
                                    {{-- @foreach ($store as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>

                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            <div class="col-md">
                                <label for="">Daily Sales Total</label>
                                <input type="text" name="total"
                                    class="form-control @error('total') is-invalid @enderror" id="rupiah">
                                @if($errors->has('total'))
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $errors->first('total') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-md">
                                <label for="">Invoice</label>
                                <input type="file" name="invoice"
                                    class="form-control @error('invoice') border border-danger @enderror" id="">
                                @if ($errors->has('invoice'))
                                <div class="text-danger">{{$errors->first('invoice')}}</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
