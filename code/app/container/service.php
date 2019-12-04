<?php

use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\Service\SeriesService;
use BestThor\ScrappingMaster\Infrastructure\Service\GeneralService;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;

$container->register(
    ElementGeneralParser::class,
    ElementGeneralParser::class
)->addArgument(new Reference(ElementGeneralFactory::class));

$container->register(
    ElementDetailParser::class,
    ElementDetailParser::class
)->addArgument(new Reference(ElementDetailFactory::class));

$container->register(
    ElementSeriesFactory::class,
    ElementSeriesFactory::class
);

$container->register(
    ElementSeriesParser::class,
    ElementSeriesParser::class
)
    ->addArgument(new Reference(ElementSeriesFactory::class));

$container->register(
    ElementSeriesDetailParser::class,
    ElementSeriesDetailParser::class
)
    ->addArgument(new Reference(ElementSeriesImageFactory::class))
    ->addArgument(new Reference(ElementSeriesDetailFactory::class));

$container->register(
    ElementSeriesDownloadParser::class,
    ElementSeriesDownloadParser::class
)
    ->addArgument(new Reference(ElementSeriesDownloadFactory::class));

$container->register(
    ElementDownloadParser::class,
    ElementDownloadParser::class
)->addArgument(new Reference(ElementDownloadFactory::class));

$container->register(
    GuzzleMTContentReaderRepository::class,
    GuzzleMTContentReaderRepository::class
)
    ->addArgument('%homeUrl%')
    ->addArgument('%filmUrl%')
    ->addArgument('%seriesUrl%')
    ->addArgument('%downloadElementUrl%')
    ->addArgument('%seriesDownloadUrl%');

$container->register(
    TemplateRenderer::class,
    TemplateRenderer::class
)
    ->addArgument('%TemplateDir%')
    ->addArgument('%TemplateOptions%');

$container->register(
    SeriesService::class,
    SeriesService::class
)
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(ElementSeriesParser::class))
    ->addArgument(new Reference(ElementSeriesDetailParser::class))
    ->addArgument(new Reference(ElementSeriesDownloadParser::class));

$container->register(
    GeneralService::class,
    GeneralService::class
)
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(ElementGeneralParser::class))
    ->addArgument(new Reference(ElementDetailParser::class))
    ->addArgument(new Reference(ElementDownloadParser::class));

$container->register(
    TransmissionClient::class,
    TransmissionClient::class
)
    ->addArgument(getenv('TRANSMISSION_HOSTNAME'))
    ->addArgument(getenv('TRANSMISSION_PORT'))
    ->addArgument(getenv('TRANSMISSION_USERNAME'))
    ->addArgument(getenv('TRANSMISSION_PASSWORD'));

