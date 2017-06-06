@extends("layouts.admin")
@section("title")
    Category Statistics
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Sale</th>
                        <th>Revenue</th>
                    </tr>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$category->category->name}}</td>
                            <td>{{$category->sales}}</td>
                            <td>{{$category->revenue}}</td>
                        </tr>
                    @endforeach
                </table>
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection