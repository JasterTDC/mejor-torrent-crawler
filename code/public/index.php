<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../env/.env');

$application = AppFactory::create();

$container = new ContainerBuilder();

$loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../app/container'));

$loader->load('setting.php');
$loader->load('factory.php');
$loader->load('repository.php');
$loader->load('service.php');
$loader->load('use_case.php');
$loader->load('transformer.php');
$loader->load('controller.php');
$loader->load('command.php');

AppFactory::setContainer($container);

$application->addRoutingMiddleware();
$application->addErrorMiddleware(true, true, true);

require_once __DIR__ . '/../slim-fw/routes.php';

$application->run();
