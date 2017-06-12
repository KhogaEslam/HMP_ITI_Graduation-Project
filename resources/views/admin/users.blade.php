@extends('layouts.admin')
@section('title')
    Admin Panel | All users
@endsection
@section('content')
    <div class="row">
        <div  class="col-md-12">
            <h1 class="bordered-heading">
                All Users
            </h1>
            <div>
                <a href="/admin/users/new-admin" class="btn btn-primary"> New Admin </a>
            </div>
            <table class="table table-striped">
                <thead>
                <th>
                    User Name
                </th>
                <th>
                    Email Address
                </th>
                <th>
                    Gender

                </th>
                <th>
                    Role
                </th>
                <th>
                    Status
                </th>

                <th colspan="2">
                    Actions
                </th>
                </thead>
                @foreach($users as $user)
                    <tr>

                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->userDetails->gender ? "Female" : "Male"}}
                        </td>
                        <td>
                            {{$user->roles[0]->name}}
                        </td>
                        @if ( $user->userDetails->status == '0')
                            <td>
                                Active
                            </td>
                            <td>
                                <form method="POST" action="{{action("AdminController@blockUser", [$user])}}">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-success"> Block </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{action("AdminController@suspendUser", [$user])}}">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-success"> Suspend </button>
                                </form>
                            </td>
                        @elseif($user->userDetails->status == '1')
                            <td>
                                Suspended
                            </td>
                            <td>
                                <form method="POST" action="{{action("AdminController@blockUser", [$user])}}">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-success"> Block </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{action("AdminController@unsuspendUser", [$user])}}">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-success"> Unsuspend </button>
                                </form>
                            </td>
                        @elseif($user->userDetails->status == '2')
                            <td>
                                Blocked
                            </td>
                            <td>

                            </td>
                            <td></td>
                        @endif


                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection