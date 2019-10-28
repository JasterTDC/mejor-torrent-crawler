<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class SaveElementInFileUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SaveElementInFileUseCaseArguments
{

    /**
     * @var ElementGeneral
     */
    protected $elementGeneral;

    /**
     * SaveElementInFileUseCaseArguments constructor.
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
