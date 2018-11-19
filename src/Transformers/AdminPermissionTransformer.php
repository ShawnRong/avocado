<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use ShawnRong\Avocado\Models\Permission;
use ShawnRong\Avocado\Transformers\AdminPermissionGroupTransformer;

class AdminPermissionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['group'];

    public function transform(Permission $permission)
    {
        return $permission->attributesToArray();
    }

    public function includeGroup(Permission $permission)
    {
        return $this->item($permission->group, new AdminPermissionGroupTransformer());
    }
}
