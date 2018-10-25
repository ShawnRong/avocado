# 🥑Avocado
## Single Page Laravel admin panel based on vuejs 


### Install 

`composer require shawnrong/avocado`

`php artisan avocado:install`

`php artisan migrate`

`php db:seed --class="ShawnRong\Avocado\Database\AvocadoTableSeeder"`

edit `.env` file, add config:
`API_PREFIX="api"`

update config/auth.php

``` php
'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'admin',
    ]
]
'providers' => [
    'admin' => [
        'driver' => 'eloquent',
        'model' => ShawnRong\Avocado\Models\AdminUser::class,
    ]
]
```

`php artisan api:cache`

