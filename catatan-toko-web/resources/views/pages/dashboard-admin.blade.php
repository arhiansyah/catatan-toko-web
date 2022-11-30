@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
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
                                @foreach ($admin as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->day)->isoFormat('D-M-Y') }}</td>
                                    <td>{{ $item->invoice }}</td>
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
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h3>Report Chart</h3>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');
    // var ctx2 = document.getElementById('myChart2').getContext('2d');
    var labels = {{ Js::from($day) }}
    var labelsMonth = {{ Js::from($month) }}
    var day = {{ Js::from($totalCountDay) }}
    var month = {{ Js::from($totalCountMonth) }}
    var year = {{ Js::from($totalCountYear) }}
    // console.log(month);
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Report Daily',
                data: day,
                borderWidth: 3,
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
            },
            {
                label: 'Report Months',
                data: month,
                borderWidth: 1,
                fill: true,
                borderColor: 'rgb(66, 245, 203)',
            },
            {
                label: 'Report Years',
                data: year,
                borderWidth: 2,
                fill: true,
                borderColor: 'rgb(247, 35, 205)',
            },
        ]
        },
        options:
        {
            animation: {
                duration: 0, // general animation time
            },
            hover: {
                animationDuration: 0, // duration of animations when hovering an item
            },
            responsiveAnimationDuration: 0, // animation duration after a resize
        }
    });
</script>
@endsection
