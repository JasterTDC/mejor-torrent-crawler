<?php

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Notification\SendNotificationUseCase;
use BestThor\ScrappingMaster\Infrastructure\Command\GeneralCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\SendNotificationCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\SeriesCrawlerCommand;
use Symfony\Component\DependencyInjection\Reference;

$container->register(
    SeriesCrawlerCommand::class,
    SeriesCrawlerCommand::class
)->addArgument(new Reference(GetElementSeriesCollectionUseCase::class));

$container->register(
    GeneralCrawlerCommand::class,
    GeneralCrawlerCommand::class
)->addArgument(new Reference(GetElementGeneralCollectionUseCase::class));

$container->register(
    SendNotificationCommand::class,
    SendNotificationCommand::class
)->addArgument(new Reference(SendNotificationUseCase::class));
