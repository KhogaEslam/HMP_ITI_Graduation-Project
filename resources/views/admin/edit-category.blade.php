
<div class="containe @if ( count($errors))
@foreach($errors->all() as $error)
{{$error}}
@endforeach
@endifr">
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action = "{{action("AdminController@updateCategory", [$cat])}}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="text" placeholder="Category name" name="name" value={{$cat->name}}>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"> Edit category </button>
                </div>
            </form>
        </div>
    </div>
</div>
