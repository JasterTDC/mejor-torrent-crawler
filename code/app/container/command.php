<?php

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetTagFromGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Notification\SendNotificationUseCase;
use BestThor\ScrappingMaster\Infrastructure\Command\GetTagFromGeneralCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\SendNotificationCommand;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\Command\SeriesCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\GeneralCrawlerCommand;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionUseCase;

$container->register(
    SeriesCrawlerCommand::class,
    SeriesCrawlerCommand::class
)->addArgument(new Reference(GetElementSeriesCollectionUseCase::class));

$container->register(
    GeneralCrawlerCommand::class,
    GeneralCrawlerCommand::class
)->addArgument(new Reference(GetElementGeneralCollectionUseCase::class));

$container->register(
    GetTagFromGeneralCommand::class,
    GetTagFromGeneralCommand::class
)->addArgument(new Reference(GetTagFromGeneralUseCase::class));

$container->register(
    SendNotificationCommand::class,
    SendNotificationCommand::class
)->addArgument(new Reference(SendNotificationUseCase::class));
