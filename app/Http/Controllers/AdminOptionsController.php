<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class AdminOptionsController extends Controller
{
    public function index()
    {
        $topics = Topic::latest()->get();
        return view('admin.options', ['topics' => $topics]);
    }

    public function toggleVisibility(Topic $topic)
    {
        $topic->update(['is_visible' => !$topic->is_visible]);
        return back()->with('success', 'Topic visibility toggled successfully.');
    }
}
