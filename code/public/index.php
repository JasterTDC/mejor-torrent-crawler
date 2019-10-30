<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$containerBuilder = require_once __DIR__ . '/../symfony-fw/dependencies.php';

$application = AppFactory::create();

AppFactory::setContainer($containerBuilder);

$application->addRoutingMiddleware();
$application->addErrorMiddleware(true, true, true);

require_once __DIR__ . '/../symfony-fw/routes.php';

$application->run();
