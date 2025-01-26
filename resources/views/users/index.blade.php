@extends('master')

@section('users', 'active')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4">
        <!-- Search Form -->
        <form method="GET" action="/users" class="mb-3">
            <div class="row">
                <div class="col-md-5">
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control" 
                        placeholder="Search by Name" 
                        value="{{ request('name') }}"
                    >
                </div>
                <div class="col-md-5">
                    <input 
                        type="text" 
                        name="email" 
                        class="form-control" 
                        placeholder="Search by Email" 
                        value="{{ request('email') }}"
                    >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Users Table -->
        <div class="card">
            <h5 class="card-header">All Users</h5>
            <div class="table-responsive text-nowrap">
                <table class="table" id="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            @if (auth()->user() && auth()->user()->can('manage_users'))
                            <th>Edit</th>
                            @endif

                            @if (auth()->user() && auth()->user()->can('delete_users'))
                            <th>Delete</th>
                            @endif

                            @if (auth()->user() && auth()->user()->can('manage_users'))
                            <th>Change Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="users-body">
                        @foreach ($users as $user)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-label-primary me-1">
                                    @if(!$user->deactivated)
                                        ACTIVE
                                    @else
                                        NOT ACTIVE
                                    @endif
                                </span>
                            </td>

                        @if (auth()->user() && auth()->user()->can('manage_users'))
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('users.edit', $user->id) }}">
                                    <i class="bx bx-edit-alt"></i> Edit
                                </a>
                            </td>
                        @endif

                        @if (auth()->user() && auth()->user()->can('delete_users'))
                            <td>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        @endif

                        @if (auth()->user() && auth()->user()->can('manage_users'))
                            <td>
                                <a class="btn btn-sm btn-success" href="{{ route('users.change_status', $user->id) }}">
                                    @if(!$user->deactivated)
                                        DEACTIVATE
                                    @else
                                        REACTIVATE
                                    @endif
                                </a>
                            </td>
                        @endif
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
