<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/11/17
 * Time: 11:19 AM
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__.'/app/bootstrap/app.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $app['orm.em'];

return ConsoleRunner::createHelperSet($entityManager);