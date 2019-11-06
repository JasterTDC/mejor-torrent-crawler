<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDetail;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class RetrieveElementDetailContentUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementDetail
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDetailContentUseCaseArguments
{

    /**
     * @var ElementGeneral
     */
    protected $elementGeneral;

    /**
     * RetrieveElementDetailContentUseCaseArguments constructor.
     * @param ElementGeneral $elementGeneral
     */
    public function __construct(
        ElementGeneral $elementGeneral
    ) {
        $this->elementGeneral = $elementGeneral;
    }

    /**
     * @return ElementGeneral
     */
    public function getElementGeneral(): ElementGeneral
    {
        return $this->elementGeneral;
    }
}
