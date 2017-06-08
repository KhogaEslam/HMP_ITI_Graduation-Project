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
                        <th>Phone</th>
                        <th>Delete</th>
                    </tr>
                    @foreach($phones as $phone)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$phone->number}}</td>
                            <td>
                                {!! Form::open(["action" => ["VendorController@deletePhone", $phone]]) !!}
                                {!! Form::button("<i class='fa fa-times'></i>", ["type" => "submit", "class" => "text-danger transparent"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
                <a href="{{action("VendorController@showNewPhonesForm")}}" class="btn btn-default">Add new phone numbers</a>
            </div>
        </div>
    </div>
@endsection