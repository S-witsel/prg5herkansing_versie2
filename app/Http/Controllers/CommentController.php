<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Topic;

class CommentController extends Controller
{
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'topic_id' => $topic->id,
            'content' => $request->input('content'),
        ]);

        return redirect()->route('topics.show', $topic)->with('success', 'Comment added successfully.');
    }
}
