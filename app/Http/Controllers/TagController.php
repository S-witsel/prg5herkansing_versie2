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
}
