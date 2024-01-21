
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
        <h3>Edit Tags:</h3>
        <form action="{{ route('topics.updateTags', $topic) }}" method="post">
            @csrf
            @method('PUT')

            <label for="tag_ids">Select Tags:</label>
            <select name="tag_ids[]" id="tag_ids" multiple>
                @foreach($allTags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $topic->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Update Tags</button>
        </form>
    </div>
@endsection
