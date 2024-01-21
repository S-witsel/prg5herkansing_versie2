@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create a New Topic</h1>

        <form action="{{ route('topics.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
            </div>

            <label>Select Tags:</label>

            <div class="tag-grid">
                @foreach($allTags as $tag)
                    <div class="tag-checkbox">
                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}" {{ old('tag_ids') && in_array($tag->id, old('tag_ids')) ? 'checked' : '' }}>
                        <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Create Topic</button>
        </form>
    </div>
@endsection
