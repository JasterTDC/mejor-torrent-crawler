<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralFactoryInterface;

/**
 * Class ElementFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralFactory implements ElementGeneralFactoryInterface
{

    /**
     * @var ElementDetailFactory
     */
    protected $elementDetailFactory;

    /**
     * @var ElementDownloadFactory
     */
    protected $elementDownloadFactory;

    /**
     * ElementGeneralFactory constructor.
     *
     * @param ElementDetailFactory $elementDetailFactory
     * @param ElementDownloadFactory $elementDownloadFactory
     */
    public function __construct(
        ElementDetailFactory $elementDetailFactory,
        ElementDownloadFactory $elementDownloadFactory
    ) {
        $this->elementDetailFactory = $elementDetailFactory;
        $this->elementDownloadFactory = $elementDownloadFactory;
    }

    /**
     * @param array $rawElementGeneral
     *
     * @return ElementGeneral
     */
    public function createFromRawElementGeneral(
        array $rawElementGeneral
    ) : ElementGeneral {
        return new ElementGeneral(
            (int) $rawElementGeneral['elementId'],
            (string) $rawElementGeneral['elementName'],
            (string) $rawElementGeneral['elementSlug'],
            (string) $rawElementGeneral['elementLink'],
            null,
            null
        );
    }

    /**
     * @param array $rawElementGeneralCollection
     *
     * @return ElementGeneralCollection
     */
    public function createFromRawElementGeneralCollection(
        array $rawElementGeneralCollection
    ) : ElementGeneralCollection {
        $elementGeneralCollection = new ElementGeneralCollection();

        foreach ($rawElementGeneralCollection as $rawElementGeneral) {
            $elementGeneralCollection->add(
                $this->createFromRawElementGeneral(
                    $rawElementGeneral
                )
            );
        }

        return $elementGeneralCollection;
    }
}
