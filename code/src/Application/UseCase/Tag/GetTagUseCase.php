<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Tag;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Domain\Tag\TagCriteria;
use BestThor\ScrappingMaster\Domain\Tag\TagReaderRepositoryInterface;

/**
 * Class GetTagUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagUseCase
{
    /** @var TagReaderRepositoryInterface */
    protected $tagReaderRepository;

    /**
     * GetTagUseCase constructor.
     *
     * @param TagReaderRepositoryInterface $tagReaderRepository
     */
    public function __construct(
        TagReaderRepositoryInterface $tagReaderRepository
    ) {
        $this->tagReaderRepository = $tagReaderRepository;
    }

    /**
     * @return GetTagUseCaseResponse
     */
    public function handle(): GetTagUseCaseResponse {
        $tagCriteria = new TagCriteria();

        $tagCriteria->setOrderBy(TagCriteria::ORDER_NAME);
        $tagCriteria->setOderType(TagCriteria::ORDER_TYPE_ASC);

        $tagCollection = $this
            ->tagReaderRepository
            ->findAll($tagCriteria);

        return new GetTagUseCaseResponse(
            true,
            $tagCollection
        );
    }
}
