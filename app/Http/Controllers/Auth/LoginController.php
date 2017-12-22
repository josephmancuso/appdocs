<?php

namespace App\Http\Controllers\Auth;

use Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function githubToProvider()
    {
        return Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect();
    }

    public function githubFromProvider()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return 'could not login';
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser);

        return redirect('/home');
    }

    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }

        return User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_token' => $githubUser->token,
            'github_id' => $githubUser->id
        ]);
    }
}
