@extends('layouts.customer')
@section('title')
    About
@endsection
@section('content')
    <div class="row about">
        <div class="container">
            <div class="col-md-6">
                <h2>About Gadgetly</h2>
                <p>Gadgetly is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker.</p>
                <p> Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here' making it look.</p>
                <br>
                <p>Don't have a free account yet?</p>
                <button class="myButton">Create Account</button>
            </div>
            <div class="col-md-6"><img class="aboutImg" src="{{asset('images/O5VSGC1.jpg')}}"></div>
        </div>
    </div>
    <div class="row about">
        <div class="container">
            <hr>
            <h3>What you'll find on Gadgetly</h3>
            <div class="col-md-6"><img class="aboutImg" src="{{asset('images/i_essential.jpg')}}"></div>
            <div class="col-md-6">
                <h3 class="aboutTitle">Laptops</h3>
                <p>Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here.</p>
                <p>Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
            </div>
        </div>
    </div>
    <div class="row about">
        <div class="container">
            <hr>
            <div class="col-md-6">
                <h3 class="aboutTitle">Tablets</h3>
                <p>Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages Many desktop publishing packages.</p>
                <p>Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages Many desktop publishing packages.</p>
            </div>
            <div class="col-md-6"><img class="aboutImg" src="{{asset('images/tablets.jpg')}}"></div>
        </div>
    </div>
    <div class="row about">
        <div class="container">
            <hr>
            <div class="col-md-6"><img class="aboutImg" src="{{asset('images/Mobiles.jpg')}}"></div>
            <div class="col-md-6">
                <h3 class="aboutTitle">Mobiles</h3>
                <p>Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages Many desktop publishing packages.</p>
                <p>Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages Many desktop publishing packages.</p>
            </div>
        </div>
    </div>
    <div class="row about">
        <div class="container">
            <hr>
            <div class="center-block buttons">
                <button class="myButton aboutB" onclick="window.location.href='{{url('/')}}';">Shop Now</button>
                <button class="myButton aboutB">Sell on Gadgetly</button>
            </div>
        </div>
    </div>
@endsection