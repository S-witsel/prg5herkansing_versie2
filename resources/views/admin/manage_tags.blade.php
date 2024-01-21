@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    <hr>
    <div>
        <h3>Create New Tag:</h3>
        <form action="{{ route('tags.store') }}" method="post">
            @csrf

            <label for="tag_name">Tag Name:</label>
            <input type="text" name="tag_name" id="tag_name" required>

            <button type="submit">Create Tag</button>
        </form>
    </div>
    <div>
        <h3>Delete Tag:</h3>
        <form action="{{ route('tags.destroy') }}" method="post">
            @csrf
            @method('DELETE')

            <label for="tag_id">Select Tag:</label>
            <select name="tag_id" id="tag_id" required>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>

            <button type="submit">Delete Tag</button>
        </form>
    </div>
</div>
@endsection
