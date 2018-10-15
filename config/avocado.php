<?php

return [
    'super_admin' => [
        'name' => env('avocado_super_admin_name', 'admin'),
        'email' => env('avocado_super_admin_email', 'admin@test.com'),
//        'password' => bcrypt(env('avocado_super_admin_password', 'secret')),
        'provider' => env('AVOCADO_SUPER_ADMIN_PROVIDER', 'admin'),
        'auth'     => env('AVOCADO_SUPER_ADMIN_AUTH', 'auth:admin'),
        'guard'    => env('AVOCADO_SUPER_ADMIN_GUARD', 'admin'),
    ],
];
