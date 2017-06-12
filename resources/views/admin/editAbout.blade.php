@extends('layouts.admin')
@section('title')
    About | Edit
@endsection
@section('content')
    <form action="{{action("AdminController@editAboutPage", [$aboutPage])}}" method="post">

    <h3>About Gadgetly :</h3>
    <textarea name="about_gadgetly" class="form-control">@if($aboutPage) {{$aboutPage->about_gadgetly}} @endif</textarea>
    <br>

    <h3>Laptops :</h3>
    <textarea name="laptops">@if($aboutPage) {{ $aboutPage->laptops }} @endif</textarea>
    <br>

    <h3>Tablets :</h3>
    <textarea name="tablets">@if($aboutPage) {{ $aboutPage->tablets }} @endif</textarea>
    <br>

    <h3>Mobiles :</h3>
    <textarea name="mobiles">@if($aboutPage) {{ $aboutPage->mobiles }} @endif</textarea>

        <button class="btn btn-success">Save</button>
    </form>

@endsection