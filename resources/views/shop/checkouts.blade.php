@extends("layouts.vendor");
@section("title")
    Checkouts
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-responsive">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Revenue</th>
                        <th>Status</th>
                    </tr>
                    @foreach($checkouts as $checkout)
                        <tr>
                            <td>{{$checkout->product->name}}</td>
                            <td>{{$checkout->quantity}}</td>
                            <td>{{$checkout->price}}$</td>
                            <td>
                                @if($status[$checkout->status][1] == "shop")
                                    {!! Form::open(["action" => ["VendorController@updateCheckoutStatus", $checkout]]) !!}
                                        {!! Form::button($status[$checkout->status][0], [
                                        "class" => "btn btn-default",
                                        "type" => "submit"
                                        ]) !!}
                                    {!! Form::close() !!}
                                @else
                                    <p>{{$status[$checkout->status][0]}}</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection