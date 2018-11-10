# Little PHP Framework

Small MVC framework for PHP

## Features
* Template (Twig)
* Basic Auth
* Routing (Symfony Routing)
* Database (+ Simple ORM, + Tiny QueryBuilder, + Pagination generator)
* Request / Response 
* Storage (+ File Uploading Utility)

## Installation

Run those commands first

```sh
composer install
composer dump-autoload
```

### Database
Set database connection details in src/App/config.php (skip that if using docker)

You need to serve /public/ directory, this is where main index.php file is. (also can be skipped if using the docker because it is already set up)

### Serving

# To serve locally (latest macOS)
```sh
cd public
php -S localhost:1234
```

# To serve on Heroku
```sh
heroku create
git push heroku master
```

# To serve using Docker
```sh
docker-compose up -d # within root directory
```

## Libraries used
* [Twig](https://github.com/twigphp/Twig) - template engine


## Meta

Damian Balandowski – balandowski@icloud.com