@extends("layouts.customer")
@section("title")
    {{\Auth::user()->name}} Profile page
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="user-profile"> <a class="pull-right edit" href="{{action("CustomerController@showEditCustomerProfileForm")}}">Edit Your Profile</a>
                <ul>
                    <li class="profile"> <img class="center-block pro-img " src="images/profile-circle.png">
                        <p class="name ">{{\Auth::user()->name}}</p>
                    </li>
                </ul>
                <hr>
                <div class="center-block data">
                    <table class="col-lg-12 table-mar">
                        <tr>
                            <td class="title col-lg-9"> Date of Birth</td>
                            <td class="col-lg-3 pad">{{\Auth::user()->userDetails->first()->date_of_birth}}</td>
                        </tr>
                        <tr>
                            <td class="title col-lg-9">Join Date</td>
                            <td class="col-lg-3 pad">{{\Auth::user()->created_at->diffForHumans()}}</td>
                        </tr>
                        <tr>
                            <td class="title col-lg-9">Last Update</td>
                            <td class="col-lg-3 pad">{{\Auth::user()->updated_at->diffForHumans()}}</td>
                        </tr>
                        <tr>
                            <td class="title">Gender</td>
                            <td class="col-lg-3 pad">{{$gender[\Auth::user()->userDetails->first()->gender]}}</td>
                        </tr>
                    </table>
                </div>
                <div class="center-block buttons2">
                    <button class=" myButton aboutB" onclick="window.location.href='{{url('/customer/cart/track')}}';">My Oredrs</button>
                    <button class=" myButton aboutB" onclick="window.location.href='{{url('')}}';">Shopping History</button>
                </div>
            </div>
        </div>
    </div>
@endsection