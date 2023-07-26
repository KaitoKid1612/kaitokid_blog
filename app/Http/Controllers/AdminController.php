<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createTag(Request $request)
    {
        Tag::create([
            'tag_name' => $request->tagName,
        ]);
    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }
}
