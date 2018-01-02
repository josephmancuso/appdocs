<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\Markdown\Facades\Markdown;

use App\Repositories;


class MarkdownController extends Controller
{
    public function show($repo, Request $request)
    {
        ## Base url: /
        $base_directory = base_path("repos/$repo");
        $directory = $this->cleanDirectory($base_directory);

        $repository = Repositories::where('name', $repo)->first();

        if ($repository->wiki) {
            $pages = $this->cleanDirectory(base_path("repos/$repo/".$repository->default_version));
            # MUST have a home.md file
            $contents = file_get_contents($base_directory.'/'.$repository->default_version.'/home.md');
            $contents = preg_replace("/(\s*){alert}(\s*\w+)/", "<div class='alert alert-info'>$2</div>", $contents);
            // dd($contents);
            $code = Markdown::convertToHtml($contents);
            $title = 'Home';
        } else {
            $pages = $this->cleanDirectory(base_path("repos/$repo/".$repository->default_version));
            $contents = file_get_contents($base_directory.'/'.$repository->default_version.'/home.md');
            $contents = Markdown::convertToHtml($contents);
            $code = $this->compileCustomTags($contents);

            // $code =  preg_replace("/(\s*){alert}(\s*.+)/", "$1<div class='alert alert-info'>$2</div>", $contents);
            $title = 'Home';
        }

        sort($pages);
        
        $versions = $directory;

        // coming from a search
        if($request->input('q')) {
            // dd($request->all());
            $search_string = $request->input('q');
            $code = str_replace($search_string, "<span style='background-color: yellow; font-weight: bold'>$search_string</span>", $code);
        }

        return view("themes.$repository->theme.code", compact('code', 'pages', 'title', 'versions', 'repository'));
    }

    public function single($repo, $slug, Request $request)
    {
        ## Single file like /docs/1.-Installation
        $base_directory = base_path("repos/$repo");
        $versions = $directory = $this->cleanDirectory($base_directory);

        $repository = Repositories::where('name', $repo)->first();

        $pages = $this->cleanDirectory(base_path("repos/$repo/".$repository->default_version));

        $contents = file_get_contents($base_directory.'/'.$repository->default_version."/$slug.md");
        $contents = Markdown::convertToHtml($contents);
        $code = $this->compileCustomTags($contents);
    
        sort($pages);
        $title = $slug;

        // coming from a search
        if($request->input('q')) {
            // dd($request->all());
            $search_string = $request->input('q');
            $code = str_replace($search_string, "<span style='background-color: yellow; font-weight: bold'>$search_string</span>", $code);
        }

        return view("themes.$repository->theme.code", compact('code', 'pages', 'title', 'versions', 'repository'));
    }

    public function singleVersion($repo, $version, Request $request)
    {
        ## Version url like /v/current/
        $base_directory = base_path("repos/$repo/$version"); #/current
        $directory = $this->cleanDirectory($base_directory);
        $versions = $this->cleanDirectory(base_path("repos/$repo/"));

        $repository = Repositories::where('name', $repo)->first();

        $pages = $this->cleanDirectory($base_directory);
        $contents = Markdown::convertToHtml(file_get_contents($base_directory."/home.md"));

        $code = $this->compileCustomTags($contents);
        

        sort($pages);
        $title = 'Home';
        $currentVersion = $version;

        // coming from a search
        if($request->input('q')) {
            // dd($request->all());
            $search_string = $request->input('q');
            $code = str_replace($search_string, "<span style='background-color: yellow; font-weight: bold'>$search_string</span>", $code);
        }

        return view("themes.$repository->theme.code", compact('code', 'pages', 'title', 'versions', 'currentVersion', 'repository'));
    }

    public function version($repo, $version, $slug, Request $request)
    {
        ## specific verison file like: /v/current/1.-Installation
        $base_directory = base_path("repos/$repo");
        
        $versions = $this->cleanDirectory($base_directory);

        $repository = Repositories::where('name', $repo)->first();

        $directory = $base_directory."/".$version;
        $single_file = $directory .'/'. $slug.'.md';
        $pages = $this->cleanDirectory($directory);

        sort($pages);

        if (file_exists($single_file)) {
            // if the file is a .md file
            $contents = Markdown::convertToHtml(file_get_contents($single_file));

            $code = $this->compileCustomTags($contents);
        } else {
            $code = 'Could not find file';
        }

        $title = $slug;
        $currentVersion = $version;

        // coming from a search
        if($request->input('q')) {
            // dd($request->all());
            $search_string = $request->input('q');
            $code = str_replace($search_string, "<span style='background-color: yellow; font-weight: bold'>$search_string</span>", $code);
        }

        return view("themes.$repository->theme.code", compact('code', 'pages', 'title', 'versions', 'currentVersion', 'repository'));
    }

    // public function search($repo, Request $request)
    // {
    //     $str = $request->input('q');
    //     $repository = Repositories::where('name', $repo)->first();
    //     $base_directory = base_path('repos/'.$repository->name);

    //     $directoryToSearch = $base_directory.'/'.$repository->default_version;

    //     // lists all files in directory
    //     $pages = $files = $this->cleanDirectory($directoryToSearch);

    //     $results = [];
    //     foreach($files as $filename){
    //         $lines = file($directoryToSearch."/".$filename);
    //         foreach ($lines as $lineNumber => $line) {
    //             if (strpos($line, $str) !== false) {
    //                 $results[$filename][] = str_replace($str, "<span style='background-color: yellow; font-weight: bold'>$str</span>", $line);
    //             }
    //         }
    //     }

    //     $title = 'Searching for: '. $request->input('q');
    //     $versions = $this->cleanDirectory($base_directory);

    //     sort($pages);
        

    //     return view('search', compact('pages', 'title', 'versions', 'repository', 'results'));
    // }

    public function searchVersion($repo, $version, Request $request)
    {
        $str = $request->input('q');
        $repository = Repositories::where('name', $repo)->first();
        $base_directory = base_path('repos/'.$repository->name);
        

        $directoryToSearch = $base_directory.'/'.$version;

        // lists all files in directory
        $pages = $files = $this->cleanDirectory($directoryToSearch);

        sort($files);

        $results = [];
        foreach($files as $filename){
            $lines = file($directoryToSearch."/".$filename);
            foreach ($lines as $lineNumber => $line) {
                if (strpos($line, $str) !== false) {
                    $results[$filename][] = str_replace($str, "<span style='background-color: yellow; font-weight: bold'>$str</span>", $line);
                }
            }
        }

        $title = 'Searching for: '. $request->input('q');
        $versions = $this->cleanDirectory($base_directory);

        sort($pages);

        $searchQuery = $request->input('q');

        return view("themes.$repository->theme.search", compact('pages', 'title', 'versions', 'repository', 'results', 'searchQuery'));
    }

    // public function download($response, $username, $repo, $additional = '')
    // {
    //     $repository = Repositories::where('repo_id', $response['repository']['id'])->first();

    //     if ($repository->wiki) {
    //         $output = shell_exec("git clone https://github.com/$username/$repo.wiki.git " . $additional . "2>&1");
    //         return dd($output);
    //     } else {
    //         exec("git clone https://github.com/$username/$repo.git " . $additional);
    //     }
    // }

    public function sync($response, $username, $repo, $additional = 'current')
    {
        $repository = Repositories::where('repo_id', $response['repository']['id'])->first();

        return $this->fetchRepo($username, $repo, $additional, $repository);
    }

    private function removeDirectory($dirname)
    {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
            if (!$dir_handle)
                return false;
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                        if (!is_dir($dirname."/".$file))
                            unlink($dirname."/".$file);
                        else
                            $this->removeDirectory($dirname.'/'.$file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
        }  
    }

    public function cleanDirectory($array)
    {
        $clean = scandir($array);
        $clean = array_diff($clean, ['..', '.', '.git']);

        rsort($clean);
        return array_values($clean);
    }

    public function fetchRepo($github_user, $github_repo, $directory = "current", $repository)
    {
        $client = new \GuzzleHttp\Client();

        try {
            // $res = $client->request('GET', "https://api.github.com/repos/$github_user/$github_repo/contents/$repository->docs_location");

            // $response = json_decode($res->getBody()->getContents());

            $response = $repository->user->github()->api('repos')->contents()->show($github_user, $github_repo, $repository->docs_location);

            if (!file_exists(base_path("repos/$repository->name/"))) {
                mkdir(base_path("repos/$repository->name"));
            }

            if (!file_exists(base_path("repos/$repository->name/$directory/"))) {
                mkdir(base_path("repos/$repository->name/$directory"));
            }

            $files = glob(base_path("repos/$repository->name/$directory/*")); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file)) {
                    unlink($file); // delete file
                }
            }


            // fetch all the files from the api call and put them in the folder
            foreach($response as $doc) {
                $file = $repository->user->github()->api('repos')->contents()->show($github_user, $github_repo, $repository->docs_location.'/'.$doc['name']);
                $getFile = $client->request('GET', $file['download_url']);
                file_put_contents(base_path("repos/$repository->name/$directory/".$doc['name']), $getFile->getBody()->getContents());
            }

            // check if a home.md file exists
            if (!file_exists(base_path("repos/$repository->name/$directory/home.md"))) {
                file_put_contents(base_path("repos/$repository->name/$directory/home.md"), '### Create your own Home.md file to replace this one');
            }

            return 'successful';
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            // docs directory does not exist

            if (!file_exists(base_path("repos/$repository->name/"))) {
                mkdir(base_path("repos/$repository->name"));
            }

            if (!file_exists(base_path("repos/$repository->name/$directory/"))) {
                mkdir(base_path("repos/$repository->name/$directory"));
            }

            // check of a home.md file exists
            if (!file_exists(base_path("repos/$repository->name/$directory/home.md"))) {
                file_put_contents(base_path("repos/$repository->name/$directory/home.md"), '### Create your own Home.md file to replace this one');
            }

            return 'Could not fetch repo. Invalid URL passed. Check the Documentation Location on the detail page';
        }

        return 'something bad happened';
        
    }

    // needs a rendered markdown contents in here
    public function compileCustomTags($contents)
    {
        // compile
        $contents = preg_replace("/(\s*){(alert|info|note)}(\s*.+)/", "$1<div class='alert alert-info'>$3</div>", $contents);
        $contents = preg_replace("/(\s*){(danger)}(\s*.+)/", "$1<div class='alert alert-danger'>$3</div>", $contents);
        return $contents;
    }
}
