<?php

use BestThor\ScrappingMaster\Infrastructure\Command\GeneralCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\SeriesCrawlerCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Container;

require_once __DIR__ . '/../vendor/autoload.php';

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
