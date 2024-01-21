<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Topic;


class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.comment.count')->only(['create', 'store']);
    }

    public function create()
    {
        $allTags = Tag::all();
        return view('topics.create', compact('allTags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'tag_ids' => 'array|exists:tags,id',
        ]);

        $topic = auth()->user()->topics()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $topic->tags()->sync($request->input('tag_ids'));

        return redirect()->route('home')->with('success', 'Topic created successfully.');
    }

    public function index(Request $request)
    {
        $query = Topic::with('comments');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('tags')) {
            $tags = is_array($request->input('tags')) ? $request->input('tags') : explode(',', $request->input('tags'));

            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tags.id', $tags);
            });
        }

        $topics = $query->latest()->get();

        return view('home', ['topics' => $topics, 'allTags' => Tag::all()]);
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
        $allTags = Tag::all();
        $topic->load('tags');

        return view('topics.edit', compact('topic', 'allTags'));
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

    public function updateTags(Request $request, Topic $topic)
    {
        $request->validate([
            'tag_ids' => 'array|exists:tags,id',
        ]);

        $topic->tags()->sync($request->input('tag_ids'));

        return redirect()->route('topics.show', $topic)->with('success', 'Tags updated successfully.');
    }
}
