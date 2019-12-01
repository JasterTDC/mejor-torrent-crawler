<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../env/.env');

$containerBuilder = require_once __DIR__ . '/../slim-fw/dependencies.php';

$application = AppFactory::create();

AppFactory::setContainer($containerBuilder);

$application->addRoutingMiddleware();
$application->addErrorMiddleware(true, true, true);

require_once __DIR__ . '/../slim-fw/routes.php';

$application->run();
