<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create()
    {
        return response()->json([
            'msg' => 'some error message',
        ], 422);
    }
}
