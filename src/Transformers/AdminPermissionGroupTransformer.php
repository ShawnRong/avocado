<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use ShawnRong\Avocado\Models\PermissionGroup;

class AdminPermissionGroupTransformer extends TransformerAbstract
{
    public function transform(PermissionGroup $permissionGroup)
    {
        return $permissionGroup->attributesToArray();
    }
}
