<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repositories extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getGitHubName()
    {
        return $this->user->github()->api('repo')->showById($this->repo_id)['name'];
    }

    public function addWebhook()
    {
        return $this->user->github()->api('repo')->hooks()->create($this->user->github_username, $this->getGitHubName(), [
           'name' => 'web',
           'config' => [
               'url' => 'http://'.env('APP_URL').'/hook',
               'content_type' => 'json'
           ],
           'events' => ['*']
       ]);
    }
}
