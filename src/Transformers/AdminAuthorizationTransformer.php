<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use ShawnRong\Avocado\Models\AdminAuthorization;

class AdminAuthorizationTransformer extends TransformerAbstract
{
    public function transform(AdminAuthorization $authorization)
    {
        return $authorization->toArray();
    }
}
