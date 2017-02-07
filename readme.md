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
over the repositories. Create **one** environment file in the format of ```.env.<prod_environment>```.
For instance, if the environment is ```local``` then use ```.env.local```. It is advised to create
separate environment settings for various setups and environments.

Since this skeleton automatically determines which environment to use, it is important to note
that there must be **exactly one** instance of the ```.env.*``` file.

Fill up the files with all the necessary information. Check the file ```env.example```
for reference.

Other configurations can be found in the ```config``` folder. These are for other environment-specific
configurations that are not as sensitive as the ones in the environment files. For convenience, the
configuration folders for ```local``` and ```production``` environments are provided. If there's a need
for more environments, just create a new ```.env.*``` file **AND** a copy any configuration folder,
 renamed into your custom environment.

## Structure, Components, and Dependencies
This skeleton is written in PHP using the Silex framework. While primarily using PHP 5.4, It's been
tested to work in PHP 7.

In downloading its dependencies, it uses Composer as package manager. This package is also compliant
with [PSR-4 autoloader rules](http://www.php-fig.org/psr/psr-4/).

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
│   └── bootstrap.php
├── cache
├── cli-config.php
├── composer.json
├── composer.lock
├── config
│   ├── local
│   │   ├── app.php
│   │   ├── constants.php
│   │   └── database.php
│   └── production
│       ├── app.php
│       ├── constants.php
│       └── database.php
├── db.json
├── env.example
├── logs
├── phpunit.xml
├── public
│   └── index.php
├── readme.md
├── src
│   └── App
│       ├── Controllers
│       │   ├── ApplicationController.php
│       │   └── BaseController.php
│       ├── Libraries
│       │   ├── RestUtils.php
│       │   └── Util.php
│       ├── Models
│       │   ├── Application.php
│       │   ├── BaseModel.php
│       │   └── Repositories
│       │       └── BaseModelRepository.php
│       └── Routes.php
└── tests
    └── App
        └── Tests
            └── ApplicationTest.php
```

## Usage
After setting up and finishing the configurations, these are some of the things one can do:

**NOTE: WHEN CREATING ANY CLASS, PLEASE RUN ```composer dumpautoload -o``` IN ORDER TO RELOAD THE
CLASSES.**


### Create Controllers
Simply create a PHP class in the ```src/App/Controllers``` directory, and use the namespace
```App\Controllers```. It is **NECESSARY** to extend the ```Controller``` class included in the folder.

### Create Libraries and other Utility Classes
Simply create a class in the ```src/App/Libraries``` directory, and use the namespace
```App\Libraries```.

### Add routes
Inside the ```Routes.php``` file, insert all additional routes inside the ```connect()```
function, after the line

```php
    $routes = $app['controllers_factory'];
```

### Create Models
The models component of this application is written with Doctrine, therefore Doctrine rules
will apply for the most part.

In its most basic usage, create a *mapping* class under ```src/Models``` under the ```App\Models``` namespace.
Then, create the entity as one would make a PHP class. However, in order to let Doctrine ORM know how
it would go about in constructing the database table of the entity, one must put *annotations*. Please
refer [to this](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html)
for a more complete guide on how to use annotations (*developer's note: this is a temporary measure and will be
replaced soon*). Refer to this example:

```php
<?php
namespace App\Models;


/**
 * @Entity
 * @Table(name="applications")
 * @package App\Models
 */
class Application
{
    /**
     * @Id
     * @Column(type="integer")
     *
     */
    private $id;

    /**
     * @Column(type="string", length=140)
     */
    private $name;

    /**
     * @Column(type="string")
     */
    private $code;
}
```

In order to validate schema before generating entities, run

```
vendor/bin/doctrine orm:validate
```

When the validation is finished, run the following to create the entity:

```
vendor/bin/doctrine orm:generate-entities
```

This will override the manually-created classes and add some basic getter and setter methods. After
this, run

```
vendor/bin/doctrine orm:schema-tool:create
```

to create the tables.

For more reference in using Doctrine, refer [here](http://docs.doctrine-project.org/en/latest/#).

### Logging
To log in the controllers, use the included ```$_logger``` with the base controller. In places
where the ```$app``` is passed, use ```$app['monolog']``` and then follow monolog rules in logging.

### Logging
To log in the controllers, use the included ```$_logger``` with the base controller. In places
where the ```$app``` is passed, use ```$app['monolog']``` and then follow monolog rules in logging.

### Lang
To make configurable message for the app, Add messages with the following structure on config folder:

```
.
└── config
    └── lang
        ├── en
        │   ├── applications
        │   │   ├── errors.php
        │   │   └── messages.php
        │   ├── applications
        │   │   ├── errors.php
        │   │   └── messages.php  
        └── fr
            └── generic
                ├── errors.php
                └── messages.php

```
Then, use Lang from libraries:
```
  use App\Libraries\Lang;


  Lang::get("en.generic.messages.hello")
```
The Lang::get accepts 4 parameters as shown above.  


## Testing
A full-blown test suite is yet to be created. For now, Please go to ```public``` and run
```
    php -S <server_address> index.php
```
where ```server_address``` is the base url to be accessed. It's an arbitrary value but it is
preferable to use ```localhost:8080```. This will be hereafter referred to as ```baseUrl```.
