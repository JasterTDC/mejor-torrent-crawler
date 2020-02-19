<?php

use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralTagWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoTagReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoTagWriterRepository;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesDetailWriterRepository;

$writerHost = getenv('DB_ELEMENT_WRITER_HOSTNAME');
$writerPort = getenv('DB_ELEMENT_WRITER_PORT');
$writerDatabase = getenv('DB_ELEMENT_WRITER_DATABASE');

$readerHost = getenv('DB_ELEMENT_READER_HOSTNAME');
$readerPort = getenv('DB_ELEMENT_READER_PORT');
$readerDatabase = getenv('DB_ELEMENT_READER_DATABASE');

$pdoWriterDsn = "mysql:host={$writerHost};charset=utf8;port={$writerPort};database={$writerDatabase}";
$pdoReaderDsn = "mysql:host={$readerHost};charset=utf8;port={$readerPort};database={$readerDatabase}";

$container->register(
    PdoAccess::class,
    PdoAccess::class
)
    ->addArgument($pdoWriterDsn)
    ->addArgument(getenv('DB_ELEMENT_WRITER_USERNAME'))
    ->addArgument(getenv('DB_ELEMENT_WRITER_PASSWORD'));

$container->register(
    'PdoReader',
    PdoAccess::class
)
    ->addArgument($pdoReaderDsn)
    ->addArgument(getenv('DB_ELEMENT_READER_USERNAME'))
    ->addArgument(getenv('DB_ELEMENT_READER_PASSWORD'));

$container->register(
    MysqlPdoElementGeneralWriterRepository::class,
    MysqlPdoElementGeneralWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$container->register(
    MysqlPdoElementSeriesWriterRepository::class,
    MysqlPdoElementSeriesWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$container->register(
    MysqlPdoElementSeriesDetailWriterRepository::class,
    MysqlPdoElementSeriesDetailWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$container->register(
    MysqlPdoElementGeneralReaderRepository::class,
    MysqlPdoElementGeneralReaderRepository::class
)
    ->addArgument(new Reference('PdoReader'))
    ->addArgument(new Reference(ElementGeneralFactory::class));

$container->register(
    MysqlPdoElementSeriesReaderRepository::class,
    MysqlPdoElementSeriesReaderRepository::class
)
    ->addArgument(new Reference(FromMysqlElementSeriesFactory::class))
    ->addArgument(new Reference('PdoReader'));

$container->register(
    MysqlPdoTagWriterRepository::class,
    MysqlPdoTagWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$container->register(
    MysqlPdoTagReaderRepository::class,
    MysqlPdoTagReaderRepository::class
)
    ->addArgument(new Reference('PdoReader'))
    ->addArgument(new Reference(TagFactory::class));

$container->register(
    MysqlPdoElementGeneralTagWriterRepository::class,
    MysqlPdoElementGeneralTagWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));
