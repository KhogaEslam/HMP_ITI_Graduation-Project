@extends("layouts.admin")
@section("title")
    Employess
@endsection
@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive table-hover">
                <tr>
                    <th>Name</th>
                    <th colspan="10">Actions</th>
                </tr>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{$employee->self->name}}</td>
                        <td>{{link_to_action("VendorController@showEditEmployeeForm", "Edit", [$employee], ["class" => "btn btn-primary"])}}</td>
                        <td>
                            {!! Form::open(["action" => ["VendorController@deleteEmployee", $employee]]) !!}
                            {!! Form::submit("Delete", ["class" => "btn btn-danger"]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <p>No employees</p>
                @endforelse
            </table>

            <a href="{{action("VendorController@showNewEmployeeForm")}}" class="btn btn-primary btn-lg pull-right"><i class="fa fa-plus-square-o"></i> Add new employee</a>
        </div>
    </div>
</div>

@endsection