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