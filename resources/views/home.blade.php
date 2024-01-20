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
                <h5 class="card-title"><a href="{{ route('topics.show', $topic) }}">{{ $topic->title }}</a></h5>
                <p class="card-text">{{ Str::limit($topic->description, 100) }}</p>
                <p class="card-text"><small class="text-muted">Created by {{ $topic->user->name }} {{ $topic->created_at->diffForHumans() }}</small></p>
            </div>

            </div>
        @empty
            <p>No topics available.</p>
        @endforelse
    </div>
@endsection

