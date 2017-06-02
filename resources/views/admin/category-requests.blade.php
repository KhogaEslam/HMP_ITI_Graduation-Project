@extends('layouts.admin')
@section('title')
    Admin Panel | All category requests
@endsection
@section('content')
    <div class="row">
        <div  class="col-md-12">
            <h1 class="bordered-heading">
                All category requests
            </h1>
            <table class="table table-striped">
                <thead>
                <th>
                    Vendor Name
                </th>
                <th>
                    Category Name

                </th>
                <th>
                    Request date
                </th>
                <th colspan="2">
                    Actions
                </th>
                </thead>
                @foreach($catRequests as $catReq)
                    <tr>

                        <td>
                            {{$catReq->user->name}}
                        </td>
                        <td>
                            {{$catReq->name}}
                        </td>
                        <td>
                            {{$catReq->created_at->diffForHumans()}}
                        </td>
                        <td>
                            <form method="POST" action="{{action("AdminController@acceptCatCreationRequest", [$catReq])}}">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-success"> Accept </button>
                            </form>

                        </td>
                        <td>

                            <form method="POST" action="{{action("AdminController@rejectCatCreationRequest", [$catReq])}}">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-danger"> Reject </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection