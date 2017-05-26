<table>
    <tr>
        <th>Name</th>
        <th colspan="20">Actions</th>
    </tr>
    @forelse($employees as $employee)
        <tr>
            <td>{{$employee->self->name}}</td>
            <td>{{link_to_action("VendorController@showEditEmployeeForm", "Edit", [$employee])}}</td>
            <td>
                {!! Form::open(["action" => ["VendorController@deleteEmployee", $employee]]) !!}
                    {!! Form::submit("Delete") !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @empty
        <p>No employees</p>
    @endforelse
</table>

{{link_to_action("VendorController@showNewEmployeeForm", "Add new employee")}}