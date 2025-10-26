@extends('layouts.app')

@section('content')
<h1>Manage Employees</h1>

<a href="{{ route('admin.employees.create') }}" class="btn btn-primary">Add Employee</a>

@if(session('success'))
  <div>{{ session('success') }}</div>
@endif

<table>
  <thead>
    <tr>
      <th>Name</th><th>Email</th><th>Status</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employees as $employee)
      <tr>
        <td>{{ $employee->name }}</td>
        <td>{{ $employee->email }}</td>
        <td>{{ $employee->status ? 'Active' : 'Inactive' }}</td>
        <td>
          <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
          <form action="{{ route('admin.employees.toggleStatus', $employee->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">
              {{ $employee->status ? 'Deactivate' : 'Activate' }}
            </button>
          </form>
          <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
