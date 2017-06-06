@extends('layouts.admin')
@section('title')
    About
@endsection
@section('content')
    ana hena fe about
    <form action="/admin/about/edit" method="get">
        <button type="submit">Edit</button>
    </form>
@endsection