@extends('layouts.admin')
@section('title')
    About | Edit
@endsection
@section('content')
    <form action="{{action("AdminController@editAboutPage", [$aboutPage])}}" method="post">

    <h3>About Gadgetly :</h3>
    <textarea name="about_gadgetly" class="form-control">{{$aboutPage->about_gadgetly}}</textarea>
    <br>

    <h3>Laptops :</h3>
    <textarea name="laptops">{{ $aboutPage->laptops }}</textarea>
    <br>

    <h3>Tablets :</h3>
    <textarea name="tablets">{{ $aboutPage->tablets }}</textarea>
    <br>

    <h3>Mobiles :</h3>
    <textarea name="mobiles">{{ $aboutPage->mobiles }}</textarea>

        <button class="btn btn-success">Save</button>
    </form>

@endsection