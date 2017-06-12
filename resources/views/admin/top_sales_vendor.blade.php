@extends("layouts.admin")
@section("title")
    Top categories
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <h6 class="list-group-header">Top vendors (sales)</h6>
                @foreach($users as $user)
                    <a class="list-group-item  list-group-item-action justify-content-between">
                        <span class="list-group-progress" style="width: {{$user->sales / $total * 100}}%"></span>
                        {{$user->user->email}}
                        <span class="ml-a text-muted">{{$user->sales}}</span>
                    </a>
                @endforeach
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection