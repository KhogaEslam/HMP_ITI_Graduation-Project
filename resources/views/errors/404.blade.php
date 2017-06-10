<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/home.css')}}"/>
    <title>Gadgetly | Page Not Found</title>
<body>
<div class="container">
    <div class="row about">
        <div class="col-lg-12"><img class="img4 img-responsive" src="{{asset('images/404.png')}}">
            <div class="notFound text-center">
                <h4>The Page you requested was not Found</h4>
                <h4>Error Code: 404</h4>
                <button class=" myButton" onclick="window.location.href='{{url('/')}}';">Back To Home</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/bootstrap.js')}}"></script>
</body>

</html>