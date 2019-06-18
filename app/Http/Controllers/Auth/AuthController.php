<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\HomeController;
use App\Models\AdminHandleModel;
use App\User;
use Illuminate\Routing\Route;
use Validator;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/admin';
    protected $maxLoginAttempts = 10;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * 处理登录认证
     *
     * @return Response
     */
    public function postLoginV2(Request $request)
    {
        $this->validate(
            $request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $AdminHandleModel = new AdminHandleModel();
            $action           = HomeController::class . '@index';
            $Menus            = $AdminHandleModel->getMenus();
            list($res, $msg, $Menus) = $AdminHandleModel->checkFunPower($action, $Menus,1);
            if (!$res && isset($Menus[0])) {// 首页没有权限的用户登录
                return redirect()->action($Menus[0]);
            }
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors(
                [
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
    }

    public function weixin()
    {
        return \Socialite::with('weixin')->redirect();
        // return \Socialite::with('weibo')->scopes(array('email'))->redirect();
    }

    public function weixin_callback()
    {
        \Log::info('weixin_callback', [$_REQUEST]);
        $oauthUser = \Socialite::with('weixin')->user();

        var_dump($oauthUser->getId());
        var_dump($oauthUser->getNickname());
        var_dump($oauthUser->getName());
        var_dump($oauthUser->getEmail());
        var_dump($oauthUser->getAvatar());
    }
}
