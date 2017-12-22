<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;

use App\Repositories;

class MarkdownController extends Controller
{
    public function show($repo)
    {
        ## Base url: /
        $base_directory = base_path("public/$repo");
        $directory = $this->cleanDirectory($base_directory);

        $repository = Repositories::where('name', $repo)->first();

        if ($repository->wiki) {
            $pages = $this->cleanDirectory(base_path("public/$repo/".$directory[0]));
            # MUST have a home.md file
            $code = Markdown::convertToHtml(file_get_contents($base_directory.'/'.$directory[0].'/home.md'));
            $title = 'Home';
        } else {
            $pages = $this->cleanDirectory(base_path("public/$repo/".$directory[0].'/docs'));
            $code = Markdown::convertToHtml(file_get_contents($base_directory.'/'.$directory[0].'/docs/home.md'));
            $title = 'Home';
        }

        sort($pages);
        
        $versions = $directory;

        return view('code', compact('code', 'pages', 'title', 'versions'));
    }

    public function single($repo, $slug, Request $request)
    {
        ## Single file like /docs/1.-Installation
        $base_directory = base_path("public/$repo");
        $versions = $directory = $this->cleanDirectory($base_directory);

        $repository = Repositories::where('name', $repo)->first();

        if ($repository->wiki) {
            $pages = $this->cleanDirectory(base_path("public/$repo/".$directory[0]));
            $code = Markdown::convertToHtml(file_get_contents($base_directory.'/'.$directory[0]."/$slug.md"));
            $title = 'Home';
        } else {
            $pages = $this->cleanDirectory(base_path("public/$repo/".$directory[0].'/docs'));
            $code = Markdown::convertToHtml(file_get_contents($base_directory.'/'.$directory[0]."/docs/$slug.md"));
        }

        sort($pages);
        $title = $slug;

        return view('code', compact('code', 'pages', 'title', 'versions'));
    }

    public function singleVersion($repo, $version)
    {
        ## Version url like /v/current/
        $base_directory = base_path("public/$repo/$version"); #/current
        $directory = $this->cleanDirectory($base_directory);
        $versions = $this->cleanDirectory(base_path("public/$repo/"));

        $repository = Repositories::where('name', $repo)->first();

        if ($repository->wiki) {
            $pages = $this->cleanDirectory(base_path("public/$repo/$version"));
            $code = Markdown::convertToHtml(file_get_contents($base_directory."/home.md"));
            $title = 'Home';
        } else {
            $pages = $this->cleanDirectory($base_directory.'/docs');
            $code = Markdown::convertToHtml(file_get_contents($base_directory."/docs/home.md"));
        }

        sort($pages);
        $title = 'Home';
        $currentVersion = $version;

        return view('code', compact('code', 'pages', 'title', 'versions', 'currentVersion'));
    }

    public function version($repo, $version, $slug)
    {
        ## specific verison file like: /v/current/1.-Installation
        $base_directory = base_path("public/$repo");
        

        $versions = $this->cleanDirectory($base_directory);

        $repository = Repositories::where('name', $repo)->first();

        if ($repository->wiki) {
            $directory = $base_directory."/".$version;
            $single_file = $directory .'/'. $slug.'.md';
            $pages = $this->cleanDirectory($directory);
        } else {
            $directory = $base_directory."/".$version.'/docs';
            $single_file = $directory .'/'. $slug.'.md';
            $pages = $this->cleanDirectory($directory);
        }

        sort($pages);

        if (file_exists($single_file)) {
            // if the file is a .md file
            $code = Markdown::convertToHtml(file_get_contents($single_file));
        } else {
            $code = 'Could not find file';
        }

        $title = $slug;
        $currentVersion = $version;

        return view('code', compact('code', 'pages', 'title', 'versions', 'currentVersion'));
    }

    public function download($response, $username, $repo, $additional = '')
    {
        $repository = Repositories::where('repo_id', $response['repository']['id'])->first();

        if ($repository->wiki) {
            exec("git clone https://github.com/$username/$repo.wiki.git " . $additional);
        } else {
            exec("git clone https://github.com/$username/$repo.git " . $additional);
        }
    }

    public function sync($response, $username, $repo, $additional = '')
    {
        $repository = Repositories::where('repo_id', $response['repository']['id'])->first();

        $this->removeDirectory(base_path("public/".$additional));

        if ($repository->wiki) {
            exec("git clone https://github.com/$username/$repo.wiki.git " . $additional);
        } else {
            exec("git clone https://github.com/$username/$repo.git " . $additional);
        }
        
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
}
