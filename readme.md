# Silex-V
Silex-V is a basic skeleton/structure for the Silex framework. It is specifically designed for
micro-services/API's that require both database CRUD transactions and other REST services.


## Setup

### Environment Prerequisites
The machine has to have the following installed:
* **PHP** >=5.4 (This package was written with **PHP 7.0**)
* **Composer**
* Any of the following database management systems:
  - MySQL
  - Postgres
  - SQLite

### Installation
run ```composer install``` to begin downloading dependencies.

### Configuration
This package uses **environment files** to store information that should not be shared 
over the repositories. Create an environment file in the format of ```.env.<prod_environment>```.
For instance, if the environment is ```local``` then use ```.env.local```. It is advised to create
separate environment settings for various setups and environments.

Fill up the files with all the necessary information. Check the file ```.env.example```
for reference. 

## Structure, Components, and Dependencies
This skeleton is written in PHP using the Silex framework. While primarily using PHP 5.4, It's been
tested to work in PHP 7.

It is dependent on [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) for the environment
configuration. As for the other configuration files to be loaded on the application, it uses
[bobalazek/ConfigServiceProvider](https://github.com/bobalazek/ConfigServiceProvider).

Its database component uses [Doctrine 2](http://www.doctrine-project.org/), which supported natively
by Silex with a service provider. The ORM is also Doctrine based (the Doctrine 2 ORM 2), supported in
Silex with a [service provider](https://github.com/dflydev/dflydev-doctrine-orm-service-provider)
by dflydev.

This basic skeleton is structured as follows:
```
.
├── app
│   └── bootstrap
│       └── app.php
├── cache
├── cli-config.php
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── constants.php
│   └── database.php
├── db.json
├── logs
├── output
├── public
│   └── index.php
├── readme.md
└── src
    └── App
        ├── Controllers
        │   └── Controller.php
        ├── Libraries
        │   ├── RestUtils.php
        │   └── Util.php
        ├── Models
        └── Routes.php
```

## Testing
A full-blown test suite is yet to be created. For now, Please go to ```public``` and run
```
    php -S <server_address> index.php
```
where ```server_address``` is the base url to be accessed. It's an arbitrary value but it is
preferable to use ```localhost:8080```. This will be hereafter referred to as ```baseUrl```.