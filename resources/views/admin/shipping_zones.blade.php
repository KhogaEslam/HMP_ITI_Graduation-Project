@extends("layouts.admin")
@section("title")
    Avaliable Shipping Zones
@endsection
@section("content")
    <div class="container">
        @foreach($zones as $zone)
            <div class="row">
                <div class="col-md-4">
                    <p>{{$zone->name}}</p>
                </div>
                <div class="col-md-4">
                    <a href="{{action("AdminController@showEditShippingZoneForm", [$zone])}}" class="btn btn-primary">Edit</a>
                </div>
                <div class="col-md-4">
                    {!! Form::open(["action" => ["AdminController@deleteShippingZone", $zone]]) !!}
                    {!! Form::submit("Delete", ["class" => "btn btn-danger"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{action("AdminController@showNewShippingZoneForm")}}" class="btn btn-default">Add new shipping zone</a>
        </div>
    </div>
@endsection