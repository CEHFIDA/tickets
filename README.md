# Laravel 5 Admin Amazing tickets
tickets - a package which allows you to control tickets from users

## Require

- [adminamazing](https://github.com/selfrelianceme/adminamazing)

## How to install

Install via composer
```
composer require selfreliance/tickets
```

Migrations
```php
php artisan vendor:publish --provider="Selfreliance\tickets\TicketsServiceProvider" --tag="migrations" --force
```

And do not forget about
```php
php artisan migrate
```