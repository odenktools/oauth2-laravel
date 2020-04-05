<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialsException;
use App\Libraries\OauthProxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiLoginController extends Controller
{
    private $loginProxy;

    public function __construct(OauthProxy $loginProxy)
    {
        $this->loginProxy = $loginProxy;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $clientId = $request->get('client_id');
        $email = $request->get('email');
        $password = $request->get('password');
        try {
            $tokenUrl = '/oauth/token';
            return response()->json($this->loginProxy->attemptLogin($clientId, $email, $tokenUrl, $password));
        } catch (InvalidCredentialsException $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'refresh_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $clientId = $request->get('client_id');
        $refreshToken = $request->get('refresh_token');
        $tokenUrl = '/oauth/token';
        return response()->json($this->loginProxy->attemptRefresh($clientId, $tokenUrl, $refreshToken));
    }

    public function logout(Request $request)
    {
        $this->loginProxy->logout();
        return response()->json(['data' => 'ok'], 200);
    }
}
