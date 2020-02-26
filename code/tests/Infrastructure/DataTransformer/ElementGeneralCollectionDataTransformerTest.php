<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\General\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralCollectionMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementGeneralCollectionDataTransformer
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralCollectionDataTransformerTest extends TestCase
{

    /** @var ElementGeneralCollectionDataTransformer */
    protected ElementGeneralCollectionDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ElementGeneralCollectionDataTransformer();
    }

    public function testTransformedCollectionWithDetailAndDownload(): void
    {
        $elementGeneralCollection = ElementGeneralCollectionMother::random();

        $ret = $this->transformer->transform(
            $elementGeneralCollection
        );

        $this->assertIsArray($ret);
        $this->assertNotEmpty($ret);
    }

    public function testTransformCollectionWithEmptyDetail(): void
    {
        $elementGeneralCollection = ElementGeneralCollectionMother::createWithEmptyDetail();

        $ret = $this->transformer->transform(
            $elementGeneralCollection
        );

        $this->assertIsArray($ret);
        $this->assertNotEmpty($ret);
    }

    public function testTransformCollectionWithEmptyDownload(): void
    {
        $elementGeneralCollection = ElementGeneralCollectionMother::createWithEmptyDownload();

        $ret = $this->transformer->transform(
            $elementGeneralCollection
        );

        $this->assertIsArray($ret);
        $this->assertNotEmpty($ret);
    }
}
