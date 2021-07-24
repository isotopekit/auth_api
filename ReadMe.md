## Install

```
composer require isotopekit/auth_api @dev
```

## Config

```
php artisan vendor:publish --provider="IsotopeKit\AuthAPI\ServiceProvider" --tag="config"
```

## Migrations

```
php artisan vendor:publish --provider="IsotopeKit\AuthAPI\ServiceProvider" --tag="migrations"
```

## Db Seed

```
php artisan db:seed --class="IsotopeKit\AuthAPI\Database\Seeders\DatabaseSeeder"
```

## Config

in config/auth.php add
```
'model' => \IsotopeKit\AuthAPI\Models\User::class,
```
under providers users array e.g.
```
'users' => [
    'driver' => 'eloquent',
	'model' => \IsotopeKit\AuthAPI\Models\User::class
],
```