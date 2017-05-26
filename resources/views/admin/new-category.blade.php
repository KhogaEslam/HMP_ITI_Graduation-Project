@extends('layouts.admin')
@section('title')
    Admin Panel | New Category
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="bordered-heading">
                 New Category
            </h1>
           <form method="POST" action = "{{action("AdminController@createCategory")}}">
               {!! csrf_field() !!}
                <div class="form-group">
                    <input  class="form-control" type="text" placeholder="Category name" name="name">
                    @if ( count($errors))
                        @foreach($errors->all() as $error)
                            <div class="statcard statcard-danger p-2 mb-2">
                                <div class="statcard-desc">
                                    {{$error}}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <button  type="submit" class="form-control btn btn-primary"> Add category </button>
                </div>
           </form>
            <a class="btn btn-outline-secondary" href="/admin/categories" > Back to all categories</a>
        </div>
    </div>
@endsection
