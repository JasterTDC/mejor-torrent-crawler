<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\Tag\GetTagUseCase;
use BestThor\ScrappingMaster\Domain\Tag\TagSearchException;
use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\Tag\MysqlPdoTagReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\Tag\TagCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Infrastructure\Repository\PDOMockUtilsTestCase;

/**
 * Class GetTagUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagUseCaseTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoTagReaderRepository */
    protected $tagReaderRepository;

    /** @var GetTagUseCase */
    protected $getTagUseCase;

    public function testIfTagCollectionIsNotEmptyThenReturnsValidResponse(): void
    {
        $this->tagReaderRepository = new MysqlPdoTagReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                TagCollectionRawMother::create()
            ),
            new TagFactory()
        );

        $this->getTagUseCase = new GetTagUseCase(
            $this->tagReaderRepository
        );

        $response = $this->getTagUseCase->handle();

        $this->assertTrue($response->isSuccess());
        $this->assertGreaterThanOrEqual(
            2,
            $response->getTagCollection()->count()
        );
    }

    public function testIfTagCollectionThrowsException(): void
    {
        $this->expectException(TagSearchException::class);

        $this->tagReaderRepository = new MysqlPdoTagReaderRepository(
            $this->mockPDOThrowException(),
            new TagFactory()
        );

        $this->getTagUseCase = new GetTagUseCase(
            $this->tagReaderRepository
        );

        $this->getTagUseCase->handle();
    }
}
