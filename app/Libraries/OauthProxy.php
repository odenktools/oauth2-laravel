<?php

namespace App\Libraries;

use App\Exceptions\InvalidCredentialsException;
use App\Repositories\UserRepository;
use Optimus\ApiConsumer\Facade\ApiConsumer;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class OauthProxy
{
    const REFRESH_TOKEN = 'refreshToken';

    private $auth;

    private $cookie;

    private $db;

    private $request;

    private $userRepository;

    private $app;

    public function __construct(Application $app, UserRepository $userRepository)
    {
        $this->app = $app;
        $this->userRepository = $userRepository;
        $this->auth = $app->make('auth');
        $this->cookie = $app->make('cookie');
        $this->db = $app->make('db');
        $this->request = $app->make('request');
    }

    /**
     * @param $email
     * @param $password
     * @return array
     * @throws InvalidCredentialsException
     */
    public function attemptLogin($email, $clientId, $tokenUrl, $password)
    {
        $user = $this->userRepository->where('email', $email)->first();

        if (!is_null($user)) {
            return $this->proxy('password', $clientId, $tokenUrl [
                'username' => $email,
                'password' => $password
            ]);
        }

        throw new InvalidCredentialsException();
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh($clientId, $tokenUrl)
    {
        $refreshToken = $this->request->cookie(self::REFRESH_TOKEN);

        return $this->proxy('refresh_token', $clientId, $tokenUrl, [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * @param $grantType
     * @param array $data
     * @return array
     * @throws InvalidCredentialsException
     */
    public function proxy($grantType, $clientId, $tokenUrl, array $data = [])
    {
        $oauth = \DB::table('oauth_clients')
            ->where('id', $clientId)
            ->first();

        if (is_null($oauth)) {
            throw new InvalidCredentialsException();
        }

        $data = array_merge($data, [
            'client_id' => $clientId,
            'client_secret' => $oauth->secret,
            'grant_type' => $grantType
        ]);

        $response = ApiConsumer::post($tokenUrl, $data);

        if (!$response->isSuccessful()) {
            throw new InvalidCredentialsException();
        }

        $data = json_decode($response->getContent());

        // Create a refresh token cookie
        $this->cookie->queue(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            864000, // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );

        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = Auth::user()->token();

        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));
    }
}
