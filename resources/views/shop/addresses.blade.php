@extends("layouts.vendor")
@section("title")
    Shop addresses
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Address</th>
                        <th>Delete</th>
                    </tr>
                    @foreach($addresses as $address)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$address->address}}</td>
                            <td>
                                {!! Form::open(["action" => ["VendorController@deleteAddress", $address]]) !!}
                                    {!! Form::button("<i class='fa fa-times'></i>", ["type" => "submit", "class" => "text-danger transparent"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection