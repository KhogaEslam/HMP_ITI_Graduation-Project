@extends("layouts.customer")
@section("title")
    {{\Auth::user()->name}} Profile page
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{\Auth::user()->name}} Profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4>Name</h4>
            </div>
            <div class="col-md-4">
                <h4>{{\Auth::user()->name}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4>Birth date</h4>
            </div>
            <div class="col-md-4">
                <h4>{{\Auth::user()->userDetails->first()->date_of_birth}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4>Joined</h4>
            </div>
            <div class="col-md-4">
                <h4>{{\Auth::user()->created_at->diffForHumans()}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4>Last update</h4>
            </div>
            <div class="col-md-4">
                <h4>{{\Auth::user()->updated_at->diffForHumans()}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4>Gender</h4>
            </div>
            <div class="col-md-4">
                <h4>{{$gender[\Auth::user()->userDetails->first()->gender]}}</h4>
            </div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-2">
                <a href="{{action("CustomerController@showEditCustomerProfileForm")}}" class="btn btn-default btn-block">Edit profile</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <a href="{{action("CustomerController@trackCheckout")}}" class="btn btn-default btn-block">Track current orders</a>
            </div>
        </div>
    </div>
@endsection