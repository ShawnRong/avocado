<?php

namespace ShawnRong\Avocado\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{

    protected $guarded = ['id'];

    public function permission()
    {
        return $this->hasMany('ShawnRong\Avocado\Models\Permission', 'pg_id');
    }
}
