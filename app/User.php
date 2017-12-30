<?php

namespace App;

use Laravel\Spark\User as SparkUser;

class User extends SparkUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'github_token',
        'github_id',
        'github_username'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function github()
    {
        $client = new \Github\Client(); 
        $client->authenticate($this->github_token, null, \Github\Client::AUTH_HTTP_TOKEN);
        return $client;
        // return app('github.factory')->make(['token' => $this->github_token, 'method' => 'token']);
    }

    public function repositories()
    {
        return $this->github()->currentUser()->repositories();
    }

    public function organizations()
    {
        return $this->github()->currentUser()->memberships()->all();
    }

    public function organizationByName($name)
    {
        return $this->github()->currentUser()->memberships()->organization($name);
    }

    public function getOrganizationRepositories($name = false)
    {
        // get all the organizations
        $repos = $this->organizations();
        $listOfRepos = [];

        // loop through them and get their repositories
        if (!$name) {
            // get all the organization repositories
            foreach($repos as $organization) {
                $organizationName = $organization['organization']['login'];
                $listOfRepos[$organizationName] = $this->github()->api('organization')->repositories($organizationName);
            }
        }

        return $listOfRepos;

    }
}
