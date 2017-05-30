@extends('layouts.admin')
@section('title')
    Admin Panel | All registration requests
@endsection
@section('content')
    <div class="row">
        <div  class="col-md-12">
            <h1 class="bordered-heading">
                All registration requests
            </h1>
            <table class="table table-striped">
                <thead>
                <th>
                    User name
                </th>
                <th>
                    Request date
                </th>
                <th colspan="2">
                    Actions
                </th>
                </thead>
                @foreach($regRequests as $regReq)
                    <tr>

                        <td>
                            {{$regReq->user->name}}
                        </td>
                        <td>
                            {{$regReq->created_at->diffForHumans()}}
                        </td>
                        <td>
                            <form method="POST" action="{{action("AdminController@acceptRegRequest", [$regReq])}}">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-success"> Accept </button>
                            </form>

                        </td>
                        <td>

                            <form method="POST" action="{{action("AdminController@rejectRegRequest", [$regReq])}}">
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