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
            $ret[] = [
                'elementId'     => $elementGeneral->getElementId(),
                'elementLink'   => $elementGeneral->getElementLink(),
                'elementSlug'   => $elementGeneral->getElementSlug(),
                'elementName'   => $elementGeneral->getElementName()
            ];
        }

        return $ret;
    }
}
