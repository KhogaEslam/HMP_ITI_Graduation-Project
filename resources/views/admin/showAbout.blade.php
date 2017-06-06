@extends('layouts.admin')
@section('title')
    About
@endsection
@section('content')
    <h3>About Gadgetly :</h3>
    <p>{!! $aboutPage->about_gadgetly !!}</p>
    <hr>

    <h3>Laptops :</h3>
    <p>{!! $aboutPage->laptops !!}</p>
    <hr>

    <h3>Tablets :</h3>
    <p>{!! $aboutPage->tablets !!}</p>
    <hr>

    <h3>Mobiles :</h3>
    <p>{!! $aboutPage->mobiles !!}</p>
    <hr>

    <button class="btn btn-success" onclick="window.location.href='{{url('/admin/about/edit')}}';">Edit</button>
@endsection