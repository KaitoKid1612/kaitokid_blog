<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
        ]);
        return Tag::create([
            'tag_name' => $request->tagName,
        ]);
    }

    public function getTag()
    {
        return response()->json(Tag::orderBy('id', 'desc')->get());
    }

    public function editTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->update([
            'tag_name' => $request->tagName,
        ]);
    }

    public function deleteTag(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->delete();
    }
}
