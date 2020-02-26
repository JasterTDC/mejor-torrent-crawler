<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Tag\GetTagDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\Tag\TagCollectionMother;
use PHPUnit\Framework\TestCase;

/**
 * Class GetTagDataTransformerTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagDataTransformerTest extends TestCase
{

    /** @var GetTagDataTransformer */
    protected GetTagDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new GetTagDataTransformer();
    }

    public function testTagCollectionTransform(): void
    {
        $tagCollection = TagCollectionMother::random();

        $collectionTransformed = $this
            ->transformer
            ->transform($tagCollection);

        $this->assertIsArray($collectionTransformed);
        $this->assertNotEmpty($collectionTransformed);
        $this->assertArrayHasKey(
            'tagActive',
            $collectionTransformed
        );
        $this->assertArrayHasKey(
            'tagCollection',
            $collectionTransformed
        );
        $this->assertIsArray($collectionTransformed['tagCollection']);
        $this->assertNotEmpty($collectionTransformed['tagCollection']);
    }
}
