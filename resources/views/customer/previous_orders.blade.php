@extends("layouts.customer")
@section("title")
    Completed orders
@endsection

@section("content")
    <div class="row allCart">
        <div class="container">
            <div class="col-md-9 col-sm-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th></th>
                        <th></th>
                        <th class="text-center">Money paid</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="">
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#">
                                        @if($order->product->images->first() !== null)
                                            <img class="media-object" src="{{route("image", $order->product->images->first()->stored_name)}}" style="width: 72px; ">
                                    @endif
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#"> {{$order->product->name}}</a></h4>
                                        <h5 class="media-heading"> In <a href="#">{{$order->product->category->name}}</a></h5>
                                    </div>
                                </div>
                            </td>

                            <td class="" style="text-align: center">
                                {{$order->quantity}}
                            </td>

                            <td></td>
                            <td></td>

                            <td class=" text-center">
                                <strong>{{$order->price}}$</strong>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection