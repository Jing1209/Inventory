@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <div class="container">
        <div class="my-2 w-100 d-flex justify-content-between">
            <div class="w-50 text-white rounded-2 me-2" style="background-color: #20c997;">
                <i class='bx bx-list-check p-2 m-3 rounded-2'
                    style="background-color: rgba(255, 255, 255, 0.16); font-size: 18px;"></i>
                <div class="mx-3 my-1">
                    Good
                    <div>
                        {{ $countGood }}
                    </div>
                </div>
            </div>
            <div class="w-50 text-white rounded-2 me-2" style="background-color: #0dcaf0;">
                <i class='bx bx-color-fill p-2 ms-3 m-3 rounded-2' style="background-color: #c3eff7; font-size: 18px;"></i>
                <div class="mx-3 mt-1 ">
                    Medium
                    <div>
                        {{ $countMedium }}
                    </div>
                </div>
            </div>
            <div class="w-50 bg-warning text-white rounded-2 me-2">
                <i class='bx bx-error p-2 ms-3 m-3 rounded-2'
                    style="background-color: rgba(255, 204, 145, 1); font-size: 18px;"></i>
                <div class="mx-3 my-1">
                    Bad
                    <div>
                        {{ $countBad }}
                    </div>
                </div>
            </div>
            <div class="w-50 bg-danger text-white rounded-2">
                <i class='bx bx-no-entry p-2 m-3 rounded-2'
                    style="background-color: rgba(255, 204, 145, 0.16); font-size: 18px;"></i>
                <div class="mx-3 my-1">
                    Broken
                    <div>
                        {{ $countBroken }}
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="d-flex flex-row-reverse my-3">
            <div class="container p-5 bg-light text-white">
                <canvas id="myChart" height="5px" width="10px"></canvas>
            </div>
        </div> --}}
        {{-- Recent Borrow --}}
        <div class="card mb-0">
            <div class="card-header">
                <div class="row d-flex">
                    <div class="col-6">
                        <h4 class="card-title mt-2">Last 3 Borrowed</h4>
                    </div>
                    <div class="col-6" align="right">

                        <button class="button">
                            <a href="/transactions" style="text-decoration:none;color: white;">View Transactions</a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive dataview">
                    <table class="table datatable ">
                        <thead>
                            <tr>
                                <th>SNo</th>
                                <th>Item</th>
                                <th>Room</th>
                                <th>Condition</th>
                                <th>Borrowed By</th>
                                <th>Borrowed Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($transactions as $key => $transaction)
                                <tr>
                                    <td style="padding-left: 20px;">{{ $key + 1 }}</td>
                                    <td>{{ $transaction->ItemName }}</td>
                                    <td>{{ $transaction->BuildingName }}-{{ $transaction->RoomName }}</td>
                                    <td>{{ $transaction->ConditionName }}</td>
                                    <td>{{ $transaction->EmployeeFirstname }} {{ $transaction->EmployeeLastname }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent item --}}
        <div class="card mb-0 my-2">
            <div class="card-header">
                <div class="row d-flex">
                    <div class="col-6">
                        <h4 class="card-title mt-2">Latest Items</h4>
                    </div>
                    <div class="col-6" align="right">

                        <button class="button">
                            <a href="/items" style="text-decoration:none;color: white;">View Items</a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive dataview">
                    <table class="table datatable ">
                        <thead>
                            <tr>
                                <th>SNo</th>
                                <th>ID</th>
                                <th>Item</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Condition</th>
                                <th>Sponsor</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($items as $key => $item)
                                <tr>
                                    <td style="padding-left: 20px;">{{ $key + 1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->item_id }}</td>
                                    <td>{{ $item->categoryName }}</td>
                                    <td>$ {{ $item->price }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        @if ($item->statusName == 'Good')
                                            <span class="text-success">{{ $item->statusName }}</span>
                                        @elseif ($item->statusName == 'Medium')
                                            <span class="text-primary">{{ $item->statusName }}</span>
                                        @elseif ($item->statusName == 'Bad')
                                            <span class="text-warning">{{ $item->statusName }}</span>
                                        @else
                                            <span class="text-danger">{{ $item->statusName }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->sponsorName }}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        var labels = {{ Js::from($labels) }};
        var users = {{ Js::from($data) }};
        const label = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];
        const label1 = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: users,
            }]
        };

        const data1 = {
            labels: label,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 15, 25],
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const config1 = {
            type: 'line',
            data: data1,
            option: {}
        }

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
        const myChart1 = new Chart(
            document.getElementById('myChart1'),
            config1
        );
    </script>
    <style>
        .button {
            background-color: #5570F1;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px
        }
    </style>
    
@endsection
