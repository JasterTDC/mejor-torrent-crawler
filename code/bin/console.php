<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Container;
use BestThor\ScrappingMaster\Infrastructure\Command\SeriesCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\GeneralCrawlerCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../env/.env');

/** @var Container $container */
$container = require_once __DIR__ . '/../slim-fw/dependencies.php';

$application = new Application();

$application->add(
    $container->get(SeriesCrawlerCommand::class)
);
$application->add(
    $container->get(GeneralCrawlerCommand::class)
);

$application->run();
