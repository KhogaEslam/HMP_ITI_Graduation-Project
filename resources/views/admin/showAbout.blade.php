@extends('layouts.admin')
@section('title')
    About
@endsection
@section('content')
    <h3>About Gadgetly :</h3>
    <p>@if($aboutPage){!! $aboutPage->about_gadgetly !!}@endif</p>
    <hr>

    <h3>Laptops :</h3>
    <p>@if($aboutPage){!! $aboutPage->laptops !!}@endif</p>
    <hr>

    <h3>Tablets :</h3>
    <p>@if($aboutPage){!! $aboutPage->tablets !!}@endif</p>
    <hr>

    <h3>Mobiles :</h3>
    <p>@if($aboutPage){!! $aboutPage->mobiles !!}@endif</p>
    <hr>

    <button class="btn btn-success" onclick="window.location.href='{{url('/admin/about/edit')}}';">Edit</button>
@endsection