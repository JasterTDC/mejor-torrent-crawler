<?php


namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;

/**
 * Class ElementGeneralCollectionDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  IsmaelMoral <jastertdc@gmail.com>
 */
final class ElementGeneralCollectionDataTransformer
{

    /**
     * @var ElementGeneralDataTransformer
     */
    protected $elementGeneralDataTransformer;

    /**
     * ElementGeneralCollectionDataTransformer constructor.
     */
    public function __construct()
    {
        $this->elementGeneralDataTransformer    = new ElementGeneralDataTransformer();
    }
    /**
     * @param ElementGeneralCollection $collection
     *
     * @return array
     */
    public function transform(
        ElementGeneralCollection $collection
    ) : array {
        $ret = [];

        /** @var ElementGeneral $elementGeneral */
        foreach ($collection as $elementGeneral) {
            $tmp = $this->elementGeneralDataTransformer
                ->transform($elementGeneral);

            $ret[] = $tmp;
        }

        return $ret;
    }
}
