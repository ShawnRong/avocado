<?php

namespace ShawnRong\Avocado\Controllers;


use ShawnRong\Avocado\Models\PermissionGroup;
use ShawnRong\Avocado\Requests\AdminPermissionGroup\CreateOrUpdateRequest;
use ShawnRong\Avocado\Transformers\AdminPermissionGroupTransformer;

class AdminPermissionGroupController extends BaseController
{

    public function index()
    {
        $permissionGroups = tap(PermissionGroup::latest(), function ($query) {
            $query->where(request()->only('name'));
        })->paginate();

        return $this->response->paginator($permissionGroups,
            new AdminPermissionGroupTransformer());
    }

    public function store(CreateOrUpdateRequest $request)
    {
        $permissionGroup = PermissionGroup::create(request()->only('name'));
        return $this->response->item($permissionGroup,
            new AdminPermissionGroupTransformer());
    }

    public function show($id)
    {
        return $this->response->item(PermissionGroup::query()->findOrFail($id),
            new AdminPermissionGroupTransformer());
    }

    public function update(CreateOrUpdateRequest $request, $id)
    {
        $permissionGroup = PermissionGroup::query()->findOrFail($id);

        $attributes = $request->only('name');
        $permissionGroup->update($attributes);

        return $this->response->noContent();
    }

    public function destroy($id)
    {
        PermissionGroup::findOrFail($id)->delete();

        return $this->response->noContent();
    }
}
