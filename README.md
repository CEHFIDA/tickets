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

## Functions

```php
/*
  @ param $id (integer)
  @ request type (get)
*/
function index($id) // get all about tickets and show blade 'show'
$this->index(1) // usage

/*
  @ param $id (integer)
  @ param $request (get)
*/
function chat($id) // get history on id ticket
$this->chat(1) // usage

/*
  @ param $id (integer)
  @ param $request (post)
*/
function send($id, Request $request) // sends a message on id ticket, transmit data: text (required)
```
