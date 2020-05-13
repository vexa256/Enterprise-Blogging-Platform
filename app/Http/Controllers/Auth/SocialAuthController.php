<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Socialite;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return Response
     */
    public function socialConnect($type)
    {
        if ($type == 'facebook') {
            return Socialite::driver($type)->stateless()->scopes(['email', 'public_profile'])->redirect();
        } else {
            return Socialite::driver($type)->redirect();
        }

        return Socialite::driver($type)->stateless()->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return Response
     */
    public function socialCallback($type, User $user)
    {

        if ($type == 'facebook') {
            $service = Socialite::driver($type)->stateless()->user();
        } else {
            $service = Socialite::driver($type)->user();
        }


        if ($service->getEmail() > "") {
            $checkUser = User::where('email', '=', $service->getEmail())->first();
            if ($checkUser) {
                Auth::login($checkUser);
                return redirect('/');
            }
        } else {
            \Session::flash('error.message', trans('auth.cantgetemail'));
            \Session::flash('username',  $service->getNickname());
            return redirect('/register');
        }

        if (null !== $service->getName() and null == $service->getNickname()) {
            $username = $service->getName();
        } else {
            $username = $service->getNickname();
        }

        $checkUserslug = User::where('username', $username)->orwhere('username_slug', $username)->first();
        if ($checkUserslug) {
            $username = $username . '-' . substr(md5(time()), 0, 5);
            $username_slug = str_slug($username, '-') . '-' . substr(md5(time()), 0, 5);
        } else {
            $username_slug = str_slug($username, '-');
        }

        $user->facebook_id = $service->getId();
        $user->username = $username;
        $user->username_slug = $username_slug;
        $user->name = $service->getName();
        $user->email = $service->getEmail();
        $user->icon  = $service->getAvatar();
        $user->remember_token = md5($service->getEmail());
        $user->save();

        Auth::login($user);

        \Session::flash('success.message', trans('auth.joined'));

        return redirect('/');
    }
}
