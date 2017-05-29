@extends('layouts.customer')

@section('title')
    Sign Up
@endsection

@section('content')
    <div class="center-block container sign-up">
        <h3>Sign Up</h3>


        <form class="center-block" role="form" method="POST" action="{{$prefix}}/register">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name</label>

                <div>
                    <input id="name" type="text" class="center-block sign" name="name" value="{{ old('name') }}"
                           required autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">E-Mail Address</label>

                <div>
                    <input id="email" type="email" class="center-block sign" name="email" value="{{ old('email') }}"
                           required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Password</label>

                <div>
                    <input id="password" type="password" class="center-block sign" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>

                <div>
                    <input id="password-confirm" type="password" class="center-block sign" name="password_confirmation"
                           required>
                </div>
            </div>

            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
                <label for="date_of_birth">Birth Date</label>

                <div>
                    <input id="date_of_birth" type="date" class="center-block sign" name="date_of_birth"
                           value="{{ old('date_of_birth') }}" required>

                    @if ($errors->has('date_of_birth'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                <label for="gender">Gender</label>

                <div>
                    <input id="gender" type="radio" name="gender" value="0" checked required/>
                    <span>Male</span>
                    <input id="gender" type="radio" name="gender" value="1" required/>
                    <span>Female</span>
                    <input id="gender" type="radio" name="gender" value="2" required/>
                    <span>Other</span>
                </div>
            </div>

            <label class="center-block"><input type="checkbox" name="terms" required> I agree with the <a href="#">Terms
                    and Conditions</a>.</label>

            <button type="submit" class="btn btn-primary center-block myButton signb">
                Sign up
            </button>

            <div class="clearfix" class="center-block"></div>

        </form>
    </div>

@endsection
