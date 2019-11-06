<?php

use BestThor\ScrappingMaster\Application\Service\RetrieveElementService;
use BestThor\ScrappingMaster\Application\Service\RetrieveElementServiceArguments;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var ContainerBuilder $containerBuilder */
$containerBuilder = require_once __DIR__ . '/../slim-fw/dependencies.php';

try {
    $page =(int) (!empty($argv[1]) ? $argv[1] : 1);

    /** @var RetrieveElementService $retrieveElementService */
    $retrieveElementService = $containerBuilder
        ->get(RetrieveElementService::class);

    $retrieveElementServiceResponse = $retrieveElementService
        ->handle(
            new RetrieveElementServiceArguments(
                $page
            )
    );

    if (!$retrieveElementServiceResponse->isSuccess()) {
        echo $retrieveElementServiceResponse->getError() . "\n";

        exit(1);
    }

    $elementGeneralCollection = $retrieveElementServiceResponse
        ->getElementGeneralCollection();

    $dataTransformer = new ElementGeneralCollectionDataTransformer();

    $elementGeneralCollectionTransformed = $dataTransformer
        ->transform(
            $elementGeneralCollection
        );

    $current = new \DateTimeImmutable();
    $file = $current->format('Ymd') . "-{$page}";

    file_put_contents(
        "/scrap/json/{$file}.json",
        json_encode($elementGeneralCollectionTransformed,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        )
    );
} catch (\Exception $e) {
    echo "[Exception]...{$e->getMessage()}\n";

    exit(1);
}