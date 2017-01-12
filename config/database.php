<?php
/**
 * database.php
 * This is a configuration file for database connections by this Middleware. Returns
 * an array of desired settings. May also read from environment files.
 * @author Gabriel John P. Gagno <ggagno@stratpoint.com>
 * @version 1.0
 * @copyright 2016 Stratpoint Technologies, Inc.
 */
use App\Libraries\Util;
return array(
    'db.options'    =>  array(
        'driver'    =>  Util::env('DB_DRIVER', 'pdo_mysql'),
        'charset'   =>  Util::env('DB_CHARSET', 'utf8'),
        'host'      =>  Util::env('DB_HOST', 'localhost'),
        'dbname'    =>  Util::env('DB_DATABASE', 'silex-v'),
        'user'      =>  Util::env('DB_USER', 'root'),
        'password'  =>  Util::env('DB_PASSWORD', 'secret')
    ),

    'orm.proxies_dir'   =>  __DIR__.'/../cache/doctrine/proxies',
    'orm.default_cache' =>  'array',
    'orm.em.options'    =>  array(
        'mappings'  =>  array(
            array(
                'type'      =>  'annotation',
                'namespace' =>  'App\Models',
                'path'      => __DIR__ . '/../src/Models'
            )
        )
    )
);