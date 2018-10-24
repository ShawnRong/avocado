<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use ShawnRong\Avocado\Models\Permission;

class AdminPermissionTransformer extends TransformerAbstract
{

    public function transform(Permission $permission)
    {
        return $permission->attributesToArray();
    }
}
