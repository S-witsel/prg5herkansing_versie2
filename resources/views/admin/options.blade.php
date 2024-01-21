@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>All Topics</h2>
                @forelse($topics as $topic)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $topic->title }}</h5>
                            <p class="card-text">Author: {{ $topic->user->name }}</p>
                            <p class="card-text">Visibility: {{ $topic->is_visible ? 'Visible' : 'Invisible' }}</p>
                            <form action="{{ route('admin.toggleVisibility', $topic) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">Toggle Visibility</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No topics available.</p>
                @endforelse
            </div>
    </div>
@endsection
