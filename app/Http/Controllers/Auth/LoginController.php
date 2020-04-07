<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Libraries\OauthProxy;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    private $loginProxy;

    public function __construct(OauthProxy $loginProxy)
    {
        $this->middleware('guest')->except('logout');
        $this->loginProxy = $loginProxy;
    }

    /**
     * OVERRIDE].
     *
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'app_id' => 'required',
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * [OVERRIDE].
     *
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        try {
            $clientId = $request->get('app_id');
            $email = $request->get('email');
            $password = $request->get('password');
            $tokenUrl = env('OAUTH2_URL_TOKEN');
            $response = $this->loginProxy->attemptLogin($clientId, $email, $tokenUrl, $password);
            if ($response) {
                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $user = Auth::user();
                    $user->createToken($email)->accessToken;
                    return true;
                }
                return false;
            }
        } catch (\Exception $e) {
            //abort(401);
            return false;
        }
    }
}
