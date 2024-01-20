<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        auth()->user()->topics()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('home')->with('success', 'Topic created successfully.');
    }

    public function index()
    {
        $topics = Topic::latest()->get();
        return view('home', ['topics' => $topics]);
    }

    public function destroy(Topic $topic)
    {
        // Check if the authenticated user is the owner of the topic
        if (auth()->user()->id !== $topic->user_id) {
            return redirect()->route('home')->with('error', 'You do not have permission to delete this topic.');
        }

        // Delete the topic
        $topic->delete();

        return redirect()->route('home')->with('success', 'Topic deleted successfully.');
    }

    public function show(Topic $topic)
    {
        return view('topics.topic_detail', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        if (auth()->user()->id !== $topic->user_id) {
            return redirect()->route('home')->with('error', 'You do not have permission to edit this topic.');
        }

        return view('topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        if (auth()->user()->id !== $topic->user_id) {
            return redirect()->route('home')->with('error', 'You do not have permission to update this topic.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $topic->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('topics.show', $topic)->with('success', 'Topic updated successfully.');
    }
}
