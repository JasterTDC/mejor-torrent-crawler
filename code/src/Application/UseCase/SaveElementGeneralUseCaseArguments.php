<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class SaveElementGeneralUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SaveElementGeneralUseCaseArguments
{

    /**
     * @var ElementGeneral
     */
    protected $elementGeneral;

    /**
     * SaveElementGeneralUseCaseArguments constructor.
     *
     * @param ElementGeneral $elementGeneral
     */
    public function __construct(ElementGeneral $elementGeneral)
    {
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
