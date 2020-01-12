<?php

use BestThor\ScrappingMaster\Infrastructure\Command\GetTagFromGeneralCommand;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use BestThor\ScrappingMaster\Infrastructure\Command\SeriesCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\GeneralCrawlerCommand;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../env/.env');

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

$application = new Application();

$application->add(
    $container->get(SeriesCrawlerCommand::class)
);
$application->add(
    $container->get(GeneralCrawlerCommand::class)
);
$application->add(
    $container->get(GetTagFromGeneralCommand::class)
);

$application->run();
