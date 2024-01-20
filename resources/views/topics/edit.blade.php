
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Topic</h1>
        <form action="{{ route('topics.update', $topic) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $topic->title }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ $topic->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Topic</button>
        </form>
    </div>
@endsection
