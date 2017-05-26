
<div class="container">
    <div class="row">
        <div class="col-md-12">
           <form method="POST" action = "{{action("AdminController@createCategory")}}">
               {!! csrf_field() !!}
                <div class="form-group">
                    <input type="text" placeholder="Category name" name="name">
                    @if ( count($errors))
                        @foreach($errors->all() as $error)
                            {{$error}}
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"> Add category </button>
                </div>
           </form>
        </div>
    </div>
</div>
