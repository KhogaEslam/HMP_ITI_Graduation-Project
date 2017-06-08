@extends("layouts.admin")
@section("title")
    Review Statistics
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Reviewed Num.</th>
                    </tr>
                    @foreach($mostReviwed as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->product->name}}</td>
                            {{--<td>{{$item->sales}}</td>--}}
                        </tr>
                    @endforeach
                </table>
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection