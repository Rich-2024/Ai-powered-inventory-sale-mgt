@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Employee Management</h1>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->username }}</td>
                        <td>{{ ucfirst($employee->status) }}</td>
                        <td>
                            <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @if($employee->status == 'active')
                                <form action="{{ route('admin.users.status', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Deactivate</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.status', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
