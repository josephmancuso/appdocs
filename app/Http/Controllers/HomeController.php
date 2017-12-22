<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\GitHub\Facades\GitHub;

use App\Http\Controllers\MarkdownController;

use App\Repositories;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        $client = Auth::user()->github();
        $repos = $client->api('user')->repositories('josephmancuso');

        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        return view('home', compact('repos', 'repoList'));
    }

    public function repo($id)
    {
        $client = Auth::user()->github();

        $singleRepo = $repo = $client->api('repo')->showById($id);

        # save repository in repo
        if (!Repositories::where('name', $singleRepo['name'])->first()) {
            $repository = new Repositories();
            $repository->repo_id = $singleRepo['id'];
            $repository->user_id = Auth::user()->id;
            $repository->owner = $singleRepo['owner']['id'];
            $repository->name = $singleRepo['name'];
            $repository->save();
        } else {
            $repository = Repositories::where('repo_id', $singleRepo['id'])->first();
        }
        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        $repos = $client->api('user')->repositories('josephmancuso');
        return view('home-repo', compact('repos', 'id', 'singleRepo', 'repository', 'repoList'));
    }

    public function detail($id) 
    {
        $client = Auth::user()->github();

        $singleRepo = $repo = $client->api('repo')->showById($id);
        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        $repository = Repositories::where('repo_id', $singleRepo['id'])->first();

        $repos = $client->api('user')->repositories('josephmancuso');

        return view('home-detail', compact('repos', 'id', 'singleRepo', 'repository', 'repoList'));
    }

    public function detailStore($id, Request $request)
    {
        $repo = Repositories::where('repo_id', $id)->first();

        $repo->name = $request->input('name');

        if ($request->has('is_wiki')) {
            $repo->wiki = 1;
        }

        $repo->save();

        return redirect()->back()->with(['message' => 'Updated Successfully']);
    }
}
