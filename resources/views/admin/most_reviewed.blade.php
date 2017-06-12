@extends("layouts.admin")
@section("title")
    Review Statistics
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Reviewed Num.</th>
                    </tr>
                    @foreach($mostReviewed as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->CommentCount ? $item->CommentCount : 0}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{$mostReviewed->links("vendor.pagination.bootstrap-4")}}
            </div>
        </div>
    </div>
@endsection