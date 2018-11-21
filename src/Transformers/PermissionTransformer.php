<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{

  public function transform(Permission $permission)
  {
    return $permission->attributesToArray();
  }

}
