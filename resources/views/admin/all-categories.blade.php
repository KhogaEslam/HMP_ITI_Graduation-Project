@extends('layouts.admin')
@section('title')
    Admin Panel | All categories
@endsection
@section('content')
    <div class="row">
        <div  class="col-md-12">
            <h1 class="bordered-heading">
                All Categories
            </h1>
            <a style="margin-bottom: 20px;" href="/admin/categories/new" class="btn btn-primary"> New Category </a>
            <table class="table table-striped">
                <thead>
                    <th>
                        Category Name
                    </th>
                    <th colspan="3">
                        Actions
                    </th>
                </thead>

                @foreach($cats as $cat)
                    <tr>
                        <td>
                            {{$cat->name}}
                        </td>
                        <td>
                            <a href="/admin/categories/{{$cat->id}}/edit" class="btn btn-warning"> Edit </a>

                        </td>
                        <td>

                            <form method="POST" action="{{action("AdminController@deleteCategory", [$cat])}}">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-danger"> Delete </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection