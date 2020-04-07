<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppAuthController extends Controller
{

    /**
     * If customer hit from API.
     *
     * @param Request $request
     * @return mixed
     */
    public function showPasswordCredentials(Request $request)
    {
        return $request->user();
    }

    /**
     * If customer hit from web.
     *
     * @param Request $request
     * @return mixed
     */
    public function webShowPasswordCredentials(Request $request)
    {
        $data = $request->user();
        return view('profile')->with(compact('data'));
    }

    public function showClientCredentials()
    {
        return response()->json(['data' => 'OK'], 200);
    }
}
