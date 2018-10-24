<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class AdminRoleTransformer extends TransformerAbstract
{

    public function transform(Role $role)
    {
        return $role->attributesToArray();
    }
}
