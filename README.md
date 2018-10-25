# 🥑Avocado
## Single Page Laravel admin panel based on vuejs 


### install 

`composer require shawnrong/avocado`

`php artisan vendor:publish --provider="ShawnRong\Avocado\AvocadoServiceProvider"`

`php artisan avocado:install`

edit `.env` file, add config:
`API_PREFIX="api"`

`php artisan migrate`

`php db:seed --class=ShawnRong\Avocado\Database\AvocadoTableSeeder`
