<?php

namespace ShawnRong\Avocado\Controllers;

use Illuminate\Support\Facades\Validator;
use ShawnRong\Avocado\Models\AdminAuthorization;
use ShawnRong\Avocado\Transformers\AdminAuthorizationTransformer;

class AuthController extends BaseController
{

    /**
     * Get a JWT via given credentials.
     */
    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email'    => 'required',
            'password' => 'required',
        ]);

        //handle error
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $credentials = request()->only('email', 'password');

        //validate token
        if (!$token = auth('api')->attempt($credentials)) {
            $this->response->errorUnauthorized('incorrect');
        }

        $authorization = new AdminAuthorization($token);

        return $this->response->item($authorization,
            new AdminAuthorizationTransformer())->setStatusCode(201);
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->response->noContent();
    }

    /**
     * Refresh a token.
     */
    public function refresh()
    {
        $authorization = new AdminAuthorization(auth('api')->refresh());
        return $this->response->item($authorization,
            new AdminAuthorizationTransformer());
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
