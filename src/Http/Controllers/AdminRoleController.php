<?php

namespace ShawnRong\Avocado\Controllers;

use Illuminate\Http\Request;
use ShawnRong\Avocado\Requests\AdminRole\CreateOrUpdateRequest;
use ShawnRong\Avocado\Transformers\AdminPermissionTransformer;
use ShawnRong\Avocado\Transformers\AdminRoleTransformer;
use Spatie\Permission\Models\Role;

class AdminRoleController extends BaseController
{

    public function index()
    {
        $roles = tap(Role::latest(), function ($query) {
            $query->where(request()->only('name'));
        })->paginate();

        return $this->response->paginator($roles, new AdminRoleTransformer());
    }

    public function store(CreateOrUpdateRequest $request)
    {
        $attributes = $request->only('name', 'guard_name', 'description');
        $role       = Role::create($attributes);

        return $this->response->item($role, new AdminRoleTransformer());
    }

    public function show($id)
    {
        return $this->response->item(Role::query()->findOrFail($id),
            new AdminRoleTransformer());
    }

    public function update(CreateOrUpdateRequest $request, $id)
    {
        $role       = Role::query()->findOrFail($id);
        $attributes = $request->only('name', 'guard_name', 'description');
        $role->update($attributes);

        return $this->response->noContent();
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return $this->response->noContent();
    }

    public function permissions($id)
    {
        $role = Role::query()->findOrFail($id);

        return $this->response->item($role->permissions,
            new AdminPermissionTransformer());
    }

    public function assignPermissions($id, Request $request)
    {
        $role = Role::query()->findOrFail($id);
        $role->syncPermissions($request->input('permissions', []));

        return $this->onContent();
    }
    
    public function guardNameRoles($guradName)
    {
        $roles = Role::query()->where('guard_name', $guradName)->get();
        return $this->response->item($roles, new AdminRoleTransformer());
    }
}
