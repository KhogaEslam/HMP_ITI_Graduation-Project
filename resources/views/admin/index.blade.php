@extends('layouts.admin')
@section('title')
    Admin Panel | Index
@endsection
@section('content')
    <div class="container">
        <div class="row">
        <div class="col-md-6 mb-6 mb-md-6">
            <div class="w-3 mx-auto">
                <canvas
                        class="ex-graph"
                        width="200" height="200"
                        data-chart="doughnut"
                        data-dataset="[{{$owner}}, {{$admin}}, {{$shop}}, {{$employee}}, {{$customer}}]"
                        data-dataset-options="{ backgroundColor: ['#26A69A', '#FFB300', '#21adb5', '#54eabe', '#FFEE58'] }"
                        data-labels="['Owner', 'Adminstrators', 'Shops', 'Employees', 'Customers']">
                </canvas>
            </div>
            <div class="text-center">
                <strong class="text-muted">Roles</strong>
                <h4>All users</h4>
            </div>
        </div>

        <div class="col-md-6 mb-6 mb-md-6">
            <div class="w-3 mx-auto">
                <canvas
                        class="ex-graph"
                        width="200" height="200"
                        data-chart="doughnut"
                        data-dataset="[{{$active}}, {{$suspended}}, {{$blocked}}]"
                        data-dataset-options="{ backgroundColor: ['#54eabe', '#21adb5', '#FFEE58'] }"
                        data-labels="['Active users', 'Suspended users', 'Blocked users']">
                </canvas>
            </div>
            <div class="text-center">
                <strong class="text-muted">Status</strong>
                <h4>User status</h4>
            </div>
        </div>
        </div>

    </div>


@endsection