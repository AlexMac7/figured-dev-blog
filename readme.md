# Figured Dev Blog

## Setup

* Clone the repository

* Install dependencies with composer and npm:

```
$ composer install && npm install
```

* Create a new MySQL database named `figured-dev-blog`
* Create a new MySQL database named `figured-dev-blog-test`

* Create a new Mongo database named `figured-dev-blog-mongo`
* Create a new Mongo database named `figured-dev-blog-mongo-test`

* Create a .env and copy the provided .env.example file to it, using your own `DB_USERNAME` and `DB_PASSWORD` if required.

* Run `php artisan key:generate`

* Run `phpunit`, all tests should pass

* Run `php artisan migrate:fresh --seed` to create a user and posts

* The user's credentials are `email` => 'admin@figured.com' and `password` => 'secret'

* Compile assets `npm run dev`

* Start a local web server with `php artisan serve --port=8001` or [Valet][2] (my environment)

* Enjoy!

This application was built with [Laravel][1].

[1]:https://laravel.com/
[2]:https://laravel.com/docs/5.6/valet