<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function manageTags()
    {
        $tags = Tag::all();

        return view('admin.manage_tags', ['tags' => $tags]);
    }

    public function createTag(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|max:255|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->input('tag_name'),
        ]);

        return redirect()->route('admin.manageTags')->with('success', 'Tag created successfully.');
    }

    public function deleteTag(Request $request)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $tag = Tag::findOrFail($request->input('tag_id'));
        $tag->delete();

        return redirect()->route('admin.manageTags')->with('success', 'Tag deleted successfully.');
    }
}
