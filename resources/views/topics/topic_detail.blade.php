@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Topic Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $topic->title }}</h5>
                <p>By {{ $topic->user->name }}</p>
                @forelse($topic->tags as $tag)
                    <span>{{ $tag->name }},</span>
                @empty
                    <span>No tags</span>
                @endforelse
                <hr>
                <p class="card-text">{{ $topic->description }}</p>
                <p class="card-text"><small class="text-muted">Created {{ $topic->created_at->diffForHumans() }}</small></p>
                <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                @auth
                    @if(auth()->user()->id === $topic->user_id)
                        <a href="{{ route('topics.edit', $topic) }}" class="btn btn-primary">Edit Topic</a>
                        <form action="{{ route('topics.destroy', $topic) }}" method="post" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Topic</button>
                        </form>
                    @endif
                @endauth

                @auth
                    <form action="{{ route('comments.store', $topic) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="content">Add a Comment:</label>
                            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                @endauth

                @if ($topic->comments && $topic->comments->count() > 0)
                    @foreach ($topic->comments as $comment)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">{{ $comment->user->name }} said:</h6>
                                <p class="card-text">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No comments yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
