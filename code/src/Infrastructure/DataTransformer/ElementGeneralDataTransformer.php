<?php


namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class ElementGeneralDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralDataTransformer
{

    /**
     * @var ElementDetailDataTransformer
     */
    protected $elementDetailDataTransformer;

    /**
     * @var ElementDownloadDataTransformer
     */
    protected $elementDownloadDataTransformer;


    /**
     * ElementGeneralDataTransformer constructor.
     */
    public function __construct()
    {
        $this->elementDetailDataTransformer     = new ElementDetailDataTransformer();
        $this->elementDownloadDataTransformer   = new ElementDownloadDataTransformer();
    }

    /**
     * @param ElementGeneral $elementGeneral
     *
     * @return array
     */
    public function transform(
        ElementGeneral $elementGeneral
    ) : array {
        $ret = [
            'id'     => $elementGeneral->getElementId(),
            'link'   => $elementGeneral->getElementLink(),
            'slug'   => $elementGeneral->getElementSlug(),
            'name'   => $elementGeneral->getElementName()
        ];

        if (!empty($this->elementDetailDataTransformer->transform($elementGeneral->getElementDetail()))) {
            $ret['detail'] = $this->elementDetailDataTransformer
                ->transform($elementGeneral->getElementDetail());
        }

        if (!empty($this->elementDownloadDataTransformer->transform($elementGeneral->getElementDownload()))) {
            $ret['download'] = $this->elementDownloadDataTransformer
                ->transform($elementGeneral->getElementDownload());
        }

        return $ret;
    }
}
