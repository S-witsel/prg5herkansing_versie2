@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div>
            <a href="{{ route('topics.create') }}" class="btn btn-primary">Create New Topic</a>
            @if(auth()->user() && auth()->user()->special_rights)
                <a href="{{ route('admin.options') }}" class="btn btn-primary">Toggle Visibility</a>
            @endif
            @if(auth()->user()->special_rights)
                <a href="{{ route('admin.manageTags') }}" class="btn btn-primary">Manage Tags</a>
            @endif
        </div>
        <hr>
        <form action="{{ route('topics.index') }}" method="GET">
            <label for="search">Search:</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or description">

            <label>Filter by Tags:</label>
            <div class="tag-grid">
                @foreach($allTags as $tag)
                    <div class="tag-checkbox">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}" {{ in_array($tag->id, (array) request('tags', [])) ? 'checked' : '' }}>
                        <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit">Apply Filters</button>
        </form>
        <hr>

        <h2>Latest Topics</h2>

        @forelse($topics as $topic)
            @if($topic->is_visible)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('topics.show', $topic) }}">{{ $topic->title }}</a></h5>
                        <p>By {{ $topic->user->name }}</p>
                        <strong>Tags:</strong>
                        @forelse($topic->tags as $tag)
                            <span>{{ $tag->name }},</span>
                        @empty
                            <span>No tags</span>
                        @endforelse
                        <hr>
                        <p class="card-text">{{ Str::limit($topic->description, 100) }}</p>
                        <p class="card-text"><small class="text-muted">Created {{ $topic->created_at->diffForHumans() }}</small></p>
                    </div>
                </div>
            @endif
        @empty
            <p>No topics available.</p>
        @endforelse
    </div>
@endsection
