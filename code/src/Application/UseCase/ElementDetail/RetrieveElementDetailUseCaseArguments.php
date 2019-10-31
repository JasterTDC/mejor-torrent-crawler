<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDetail;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class RetrieveElementDetailUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDetailUseCaseArguments
{

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var ElementGeneral|null
     */
    protected $elementGeneral;

    /**
     * RetrieveElementDetailUseCaseArguments constructor.
     *
     * @param string|null $content
     * @param ElementGeneral|null $elementGeneral
     */
    public function __construct(
        ?string $content,
        ?ElementGeneral $elementGeneral
    ) {
        $this->content = $content;
        $this->elementGeneral = $elementGeneral;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return ElementGeneral|null
     */
    public function getElementGeneral(): ?ElementGeneral
    {
        return $this->elementGeneral;
    }
}
