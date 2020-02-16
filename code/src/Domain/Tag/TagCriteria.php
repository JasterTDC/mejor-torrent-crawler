<?php

namespace BestThor\ScrappingMaster\Domain\Tag;

/**
 * Class TagCriteria
 *
 * @package BestThor\ScrappingMaster\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagCriteria
{
    public const ORDER_NAME = 1;
    public const ORDER_TYPE_ASC = 1;

    /** @var int|null */
    protected ?int $orderBy;

    /** @var int|null */
    protected ?int $oderType;

    /**
     * TagCriteria constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    /**
     * @param int|null $orderBy
     */
    public function setOrderBy(?int $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return int|null
     */
    public function getOderType(): ?int
    {
        return $this->oderType;
    }

    /**
     * @param int|null $oderType
     */
    public function setOderType(?int $oderType): void
    {
        $this->oderType = $oderType;
    }
}
