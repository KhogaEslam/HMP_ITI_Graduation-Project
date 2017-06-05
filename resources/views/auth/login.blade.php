@extends('layouts.customer')
@section('title')
    Login
@endsection

@section('content')
    <div class="center-block container sign-up">
        <h3>Log In</h3>


        <form class="center-block" role="form" method="POST" action="{{$prefix}}/login">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">E-Mail Address</label>

                <div>
                    <input id="email" type="email" class="center-block sign" name="email" value="{{ old('email') }}"
                           required autofocus>

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

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>

            <a class="center-block" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>


            <button type="submit" class="btn btn-primary center-block myButton signb">
                Login
            </button>
            <a class="signb loginBtn center-block loginBtn--facebook" href="{{route('facebook.login')}}">
                Login with Facebook
            </a>

            <div class="clearfix center-block"></div>

        </form>

    </div>
@endsection
