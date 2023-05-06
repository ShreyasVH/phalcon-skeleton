<?php

use Phalcon\Autoload\Loader;

$loader = new Loader();

$loader->setDirectories
(
    array
    (
        APP_PATH . 'app/controllers/',
    )

)->register();

$loader->setNamespaces
(
    array
    (
        'app\\controllers' => APP_PATH . 'app/controllers',
        'app\\config' => APP_PATH . 'app/config'
    )

)->register();