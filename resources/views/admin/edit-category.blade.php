@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action = "{{action("AdminController@updateCategory")}}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" placeholder="Category name" name="name" value={{$cat->name}}>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"> Add category </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
