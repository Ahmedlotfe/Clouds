@extends('master')

@section('users', 'active')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <h2 class="text-center">Edit User</h2>
        
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
        
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name" required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="email" required>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
        
                <button type="submit" class="btn btn-primary btn-block">Update User</button>
            </form>
        </div>
    </div>
@endsection
