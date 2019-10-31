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
     * @return ElementGeneral
     *
     * @throws \Exception
     */
    public function createFromRawElementGeneral(
        array $rawElementGeneral
    ) : ElementGeneral {
        try {
            $createdAt = new \DateTimeImmutable();
            $updatedAt = new \DateTimeImmutable();

            if (!empty($rawElementGeneral['createdAt'])) {
                $createdAt = \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i:s',
                    $rawElementGeneral['createdAt']
                );
            }

            if (!empty($rawElementGeneral['updatedAt'])) {
                $updatedAt = \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i:s',
                    $rawElementGeneral['updatedAt']
                );
            }

            return new ElementGeneral(
                (int) $rawElementGeneral['id'],
                (string) $rawElementGeneral['name'],
                (string) $rawElementGeneral['slug'],
                (string) $rawElementGeneral['link'],
                $createdAt,
                $updatedAt,
                $this->elementDetailFactory->createElementDetailFromRaw(
                    $rawElementGeneral
                ),
                $this->elementDownloadFactory->createFromRaw(
                    $rawElementGeneral
                )
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $rawElementGeneralCollection
     *
     * @return ElementGeneralCollection
     * @throws \Exception
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
