<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MarkdownController;

class UpdateController extends Controller
{
    public function hook(Request $request)
    {
        $value = $request->header('X-GitHub-Event');
        $response = json_decode($request->getContent(), true);
        $repo = explode('/', $response['repository']['full_name']);

        if ($value == 'gollum' || $value == 'push') {
            return (new MarkdownController)->sync($response, $repo[0], $repo[1], 'current');
            // return 'updated or pushed';
        } elseif ($value == 'release') {
            (new MarkdownController)->sync($response, $repo[0], $repo[1], $response['release']['tag_name']);
            return 'released';
        } else {
            return 'no value';
        }
    }
}
