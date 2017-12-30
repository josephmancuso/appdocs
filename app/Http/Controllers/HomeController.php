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
        $repos = Auth::user()->repositories();

        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        $repoType = 'Public Repositories';

        return view('dashboard.home', compact('repos', 'repoList', 'repoType'));
    }

    public function showPrivate()
    {
        // get private repositories
        $repos = Auth::user()->privateRepositories();

        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        $repoType = 'Private Repositories';

        return view('dashboard.home', compact('repos', 'repoList', 'repoType'));
    }

    
    public function showOrganization()
    {
        // get private repositories
        $organizations = Auth::user()->getOrganizationRepositories();

        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        $repoType = 'Organization Repositories';

        return view('dashboard.home', compact('repos', 'repoList', 'organizations', 'repoType'));
    }

    public function repo($id)
    {
        // add the repo
        $client = Auth::user()->github();

        $singleRepo = $repo = $client->api('repo')->showById($id);

        // save repository in repo
        if (!Repositories::where('name', $singleRepo['name'])->first()) {
            // create a new repo
            $repository = new Repositories();
            $repository->repo_id = $singleRepo['id'];
            $repository->user_id = Auth::user()->id;
            $repository->owner = $singleRepo['owner']['id'];
            $repository->docs_location = 'docs';

            if (!Repositories::where('name', $singleRepo['name'])->exists()) {
                $repository->name = $singleRepo['name'];
                // try fetch it
                try {
                    (new MarkdownController)->fetchRepo($singleRepo['owner']['login'], $singleRepo['name'], 'current', $repository);
                } catch(\GuzzleHttp\Exception\ClientException $e) {
                    //
                }
            }

            $repository->save();
            
            if (!$repository->name) {
                return redirect()->route('repoDetails', ['id' => $singleRepo['id']])->with(['error' => 'There is already a repo hosted here with that name. Please try a different name']);
            }
        } else {
            $repository = Repositories::where('repo_id', $singleRepo['id'])->first();
        }
        $repoList = Repositories::where('user_id', Auth::user()->id)->get();
        

        $repos = Auth::user()->repositories();
        $organizations = Auth::user()->getOrganizationRepositories();

        return redirect()->route('repoDetails', ['id' => $repository->repo_id])->with(['message' => "Great! You're repository has been verified. You can optionally add this webhook: <code>http://".env('APP_URL')."/hook</code> to your settings so we can maintain your documentation for you. More info can be found at the bottom of this page."]);
        // return view('home-repo', compact('repos', 'id', 'singleRepo', 'repository', 'repoList', 'organizations'));
    }

    public function detail($id) 
    {
        $client = Auth::user()->github();

        $singleRepo = $repo = $client->api('repo')->showById($id);
        $repoList = Repositories::where('user_id', Auth::user()->id)->get();

        $repository = Repositories::where('repo_id', $singleRepo['id'])->first();

        $repos = Auth::user()->repositories();

        $repoVersions = (new MarkdownController)->cleanDirectory(base_path("repos/$repository->name"));
        $organizations = Auth::user()->getOrganizationRepositories();

        return view('dashboard.details', compact('repos', 'id', 'singleRepo', 'repository', 'repoList', 'repoVersions', 'organizations'));
    }

    public function detailStore($id, Request $request)
    {
        // update the repo
        $repo = Repositories::where('repo_id', $id)->first();

        if ($repo->name !== $request->input('name')) {
            // changing the name of the package
            
            if ($checkRepoNameExists = Repositories::where('name', $request->input('name'))->exists()) {
                return redirect()->back()->with(['error' => 'There is already a repo hosted here with that name. Please try a different name']);
            }

            // need to change the name of the directory as well.
            rename(base_path("repos/$repo->name"), base_path("repos/$request->name"));
        }

        $repo->name = $request->input('name');
        $repo->default_version = $request->input('default_version');
        $repo->docs_location = $request->input('docs_location');

        if ($request->has('is_wiki')) {
            $repo->wiki = 1;
        } else {
            $repo->wiki = 0;
        }

        $repo->save();

        // refetch the repository

        $client = Auth::user()->github();
        $GitHubRepo = $client->api('repo')->showById($repo->repo_id);

        (new MarkdownController)->fetchRepo($GitHubRepo['owner']['login'], $GitHubRepo['name'], "current", $repo);

        return redirect()->back()->with(['message' => 'Updated Successfully. Documentation has also been downloaded.']);
    }

    public function download(Request $request)
    {
        $repo_id = $request->input('repo_id');

        $repository = Repositories::where('repo_id', $repo_id)->first();

        $client = Auth::user()->github();
        $GitHubRepo = $client->api('repo')->showById($repository->repo_id);

        (new MarkdownController)->fetchRepo($GitHubRepo['owner']['login'], $GitHubRepo['name'], "current", $repository);

        return redirect()->back()->with(['message' => 'Successfully Downloaded Repository']);
    }
}
