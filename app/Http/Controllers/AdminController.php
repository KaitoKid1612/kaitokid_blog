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

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpg,jpeg,png',
        ]);
        $pic_name = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $pic_name);
        return $pic_name;
    }

    public function deleteImage(Request $request)
    {
        $file_name = $request->image;
        $this->deleteFileFromServer($file_name);
        return 'done';
    }

    public function deleteFileFromServer($file_name)
    {
        if (file_exists(public_path() . '\uploads/' . $file_name)) {
            unlink(public_path() . '\uploads/' . $file_name);
        }
        return;
    }
}
