@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Profile</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="container">
            <h3>Your Profile Information:</h3>
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Description:</strong> {{ auth()->user()->description ?: 'Not provided' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst(auth()->user()->gender) }}</p>

            @if(auth()->user()->profile_picture)
                <img height="50px" width="50px" src="{{ asset('images/profile_pictures/' . auth()->user()->profile_picture) }}" alt="Profile Picture" class="img-fluid">
            @else
                <p><em>No profile picture available</em></p>
            @endif
        </div>



        <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ auth()->user()->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <select name="profile_picture" id="profile_picture" class="form-control">
                    <option value="avatar1.jpg" {{ auth()->user()->profile_picture === 'avatar1.jpg' ? 'selected' : '' }}>Avatar 1</option>
                    <option value="avatar2.jpg" {{ auth()->user()->profile_picture === 'avatar2.jpg' ? 'selected' : '' }}>Avatar 2</option>
                    <option value="avatar3.jpg" {{ auth()->user()->profile_picture === 'avatar3.jpg' ? 'selected' : '' }}>Avatar 3</option>
                    <option value="avatar4.jpg" {{ auth()->user()->profile_picture === 'avatar4.jpg' ? 'selected' : '' }}>Avatar 4</option>
                </select>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ auth()->user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
@endsection
