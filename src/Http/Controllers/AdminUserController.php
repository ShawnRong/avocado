<?php

namespace ShawnRong\Avocado\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use ShawnRong\Avocado\Models\AdminUser;
use ShawnRong\Avocado\Transformers\AdminUserTransformer;

class AdminUserController extends BaseController
{

    /**
     * Get all admin users
     */
    public function index()
    {
        $users = AdminUser::paginate();
        return $this->response->paginator($users, new AdminUserTransformer());
    }

    /**
     * Get specific user info
     */
    public function show($id)
    {
        $user = AdminUser::findOrFail($id);
        return $this->response->item($user, new AdminUserTransformer());
    }


    public function patch(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'name' => 'string|max:50',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $user       = $this->user();
        $attributes = array_filter($request->only('name', 'avatar'));
    }

    public function editPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'          => 'required',
            'password'              => 'required|confirmed|different:old_password',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $user = $this->user();

        $auth = Auth::once([
            'email'    => $user->email,
            'password' => $request->get('old_password'),
        ]);

        if (!$auth) {
            return $this->response->errorUnauthorized();
        }

        $password = app('hash')->make($request->get('password'));
        $user->update(['password' => $password]);

        return $this->response->noContent();
    }

    /**
     * Create a user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'email'    => 'required|email|unique:admin_users',
            'name'     => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $email    = $request->get('email');
        $password = $request->get('password');

        $attributes = [
            'email'    => $email,
            'name'     => $request->get('name'),
            'password' => app('hash')->make($password),
        ];
        $user       = AdminUser::create($attributes);

        return $this->response->item($user, new AdminUserTransformer());
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        AdminUser::delete($id);
        return $this->response->noContent();
    }
}
