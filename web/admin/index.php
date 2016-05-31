<?php

require_once __DIR__ . '/../../vendor/autoload.php';


use Admin\Application\AdminApplication;

$app = new Silex\Application();
$root = new AdminApplication($app);

$root->execute();
