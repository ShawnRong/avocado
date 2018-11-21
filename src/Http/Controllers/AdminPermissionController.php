<?php

namespace ShawnRong\Avocado\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use ShawnRong\Avocado\Models\Permission;
use ShawnRong\Avocado\Requests\AdminPermission\CreateOrUpdateRequest;
use ShawnRong\Avocado\Transformers\AdminPermissionTransformer;

class AdminPermissionController extends BaseController
{

    public function index(Request $request)
    {
        $name = $request->get('name');
        $permissionGroup = $request->get('permissionGroup');
        $guardName = $request->get('guardName');

        $permissions = Permission::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($guardName, function ($query) use ($guardName) {
                $query->where('guard_name', 'like', '%' . $guardName . '%');
            })
            ->orWhereHas('group', function ($query) use ($permissionGroup) {
                $query->where('name', 'like', '%' . $permissionGroup . '%');
            })
            ->paginate();

        return $this->response->paginator(
            $permissions,
            new AdminPermissionTransformer()
        );
    }

    public function allPermissions()
    {
        $permissions = Permission::all();
        return $this->response->collection(
            $permissions,
            new AdminPermissionTransformer()
        );
    }   

    public function store(CreateOrUpdateRequest $request)
    {
        $attributes                 = $request->only('pg_id', 'name',
            'guard_name', 'display_name', 'icon', 'sequence', 'description');
        $attributes['created_name'] = Auth::user()->name;

        $permission = Permission::create($attributes);
        return $this->response->item($permission,
            new AdminPermissionTransformer());
    }

    public function show($id)
    {
        return $this->response->item(Permission::query()->findOrFail($id),
            new AdminPermissionTransformer());
    }

    public function update(CreateOrUpdateRequest $request, $id)
    {
        $permission                 = Permission::query()->findOrFail($id);
        $attributes                 = $request->only('pg_id', 'name',
            'guard_name', 'display_name', 'icon', 'sequence', 'description');
        $attributes['updated_name'] = Auth::user()->name;

        $permission->update($attributes);

        return $this->response->noContent();
    }

    public function destroy($id)
    {
        Permission::query()->findOrFail($id)->delete();

        return $this->response->noContent();
    }
}
