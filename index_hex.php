<?php

use BestThor\ScrappingMaster\Application\Service\RetrieveElementService;
use BestThor\ScrappingMaster\Application\Service\RetrieveElementServiceArguments;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__ . '/vendor/autoload.php';

/** @var ContainerBuilder $containerBuilder */
$containerBuilder = require_once __DIR__ . '/config/dependencies.php';

try {
    /** @var RetrieveElementService $retrieveElementService */
    $retrieveElementService = $containerBuilder
        ->get(RetrieveElementService::class);

    $retrieveElementServiceResponse = $retrieveElementService
        ->handle(
            new RetrieveElementServiceArguments(
                1
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

    file_put_contents(
        __DIR__ . '/scrap-json/' . md5(time()) . '.json',
        json_encode($elementGeneralCollectionTransformed,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        )
    );
} catch (\Exception $e) {
    echo "[Exception]...{$e->getMessage()}\n";

    exit(1);
}