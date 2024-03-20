<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    function store($from, Request $request) {
        $post = $request->post();
        dump($from);
        dd($post);
    }
}
