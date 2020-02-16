<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Tag;

use BestThor\ScrappingMaster\Domain\Tag\TagCollection;

/**
 * Class GetTagUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagUseCaseResponse
{

    /** @var bool */
    protected bool $success;

    /** @var TagCollection|null */
    protected ?TagCollection $tagCollection;

    /**
     * GetTagUseCaseResponse constructor.
     * @param bool $success
     * @param TagCollection|null $tagCollection
     */
    public function __construct(bool $success, ?TagCollection $tagCollection)
    {
        $this->success = $success;
        $this->tagCollection = $tagCollection;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return TagCollection|null
     */
    public function getTagCollection(): ?TagCollection
    {
        return $this->tagCollection;
    }
}
