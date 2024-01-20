@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Topics</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div>
            <a href="{{ route('topics.create') }}" class="btn btn-primary">Create New Topic</a>
        </div>

        <hr>

        <h2>Latest Topics</h2>

        @forelse($topics as $topic)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $topic->title }}</h5>
                    <p class="card-text">{{ $topic->description }}</p>
                    <p class="card-text"><small class="text-muted">Created by {{ $topic->user->name }} at {{ $topic->created_at->diffForHumans() }}</small></p>
                </div>
                @if(auth()->check() && auth()->user()->id === $topic->user_id)
                    <form action="{{ route('topics.destroy', $topic) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        @empty
            <p>No topics available.</p>
        @endforelse
    </div>
@endsection

