<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        if ($request->ajax()) {
            return view('_forms._signupform');
        }

        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'username' => 'required|string|max:35|min:3|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ];

        if (get_buzzy_config('BuzzyRegisterCaptcha') == "on" && get_buzzy_config('reCaptchaKey') !== '') {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $slug = sanitize_title_with_dashes($data['username']);
        if (empty($slug)) {
            $slug = substr(md5(time()), 0, 10);
        }

        return User::create([
            'username' => $data['username'],
            'username_slug' => $slug,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'title' => trans('auth.congratz'),
                'text' => trans('auth.joined'),
                'url' => $this->redirectTo(),
            ]);
        }

        return redirect($this->redirectTo());
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        return request()->query('redirectTo') ?: action('UsersController@index', [\Auth::user()->username_slug]);
    }
}
