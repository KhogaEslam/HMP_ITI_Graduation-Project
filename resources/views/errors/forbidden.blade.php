<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/home.css')}}"/>
    <title>Gadgetly | Access Denied</title>

<body>
<div class="container">
    <div class="row about">
        <div class="col-lg-12"><img class="img4 img-responsive" src="{{asset('images/forbidden.png')}}">
            <div class="notFound text-center">
                <h4>Access Denied</h4>
                <h4>Error Code: 403</h4>
                <button class=" myButton " onclick="window.location.href='{{url('/')}}';">Back To Home</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/bootstrap.js')}}"></script>
</body>

</html>