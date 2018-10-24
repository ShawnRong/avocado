<?php

namespace ShawnRong\Avocado\Transformers;

use League\Fractal\TransformerAbstract;
use ShawnRong\Avocado\Models\AdminUser;

class AdminUserTransformer extends TransformerAbstract
{

    protected $authorization;

    public function transform(AdminUser $user)
    {
        return $user->attributesToArray();
    }

    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;

        return $this;
    }

    public function includeAuthorization(AdminUser $user)
    {
        if (!$this->authorization) {
            return $this->null();
        }
        return $this->item($this->authorization,
            new AdminAuthorizationTransformer());
    }
}
