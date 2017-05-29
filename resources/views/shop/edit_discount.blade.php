@extends("layouts.admin")
@section("title")
    Edit Discount
@endsection
@section("content")
{!! dd($discount) !!}
    <div class="container">
        <form class="center-block" role="form" method="POST" action="edit_discount">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="percentage">Percentage</label>

                <div>
                    <input id="percentage" type="number" class="form-control" name="percentage" value=""
                           required autofocus>
                </div>
            </div>


            <div class="form-group">
                <label for="start_date">Start Date</label>

                <div>
                    <input id="start_date" type="date" class="form-control" name="start_date"
                           value="" required>
                </div>
            </div>


            <div class="form-group">
                <label for="end_date">End Date</label>

                <div>
                    <input id="end_date" type="date" class="form-control" name="end_date"
                           value="" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Add
            </button>

            <div class="clearfix" class="center-block"></div>

        </form>
    </div>

@endsection