@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Topic Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $topic->title }}</h5>
                <p class="card-text">{{ $topic->description }}</p>
                <p class="card-text"><small class="text-muted">Created by {{ $topic->user->name }} {{ $topic->created_at->diffForHumans() }}</small></p>
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
            </div>
        </div>
    </div>
@endsection
