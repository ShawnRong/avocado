<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;
use ShawnRong\Avocado\Transformers\PermissionTransformer;

class AdminRoleTransformer extends TransformerAbstract
{
	  protected $defaultIncludes = ['permissions'];

    public function transform(Role $role)
    {
        return $role->attributesToArray();
    }

    public function includePermissions(Role $role)
    {
        $permissions = $role->permissions;
        return $this->collection($permissions, new PermissionTransformer);
    }
}
