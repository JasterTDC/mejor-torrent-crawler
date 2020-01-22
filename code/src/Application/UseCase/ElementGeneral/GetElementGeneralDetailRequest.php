<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class GetElementGeneralDetailRequest
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralDetailRequest
{

    /**
     * Element general identifier
     *
     * @var int
     */
    protected $elementGeneralId;

    /**
     * GetElementGeneralDetailRequest constructor.
     * @param int $elementGeneralId
     */
    public function __construct(int $elementGeneralId)
    {
        $this->elementGeneralId = $elementGeneralId;
    }

    /**
     * @return int
     */
    public function getElementGeneralId(): int
    {
        return $this->elementGeneralId;
    }
}
