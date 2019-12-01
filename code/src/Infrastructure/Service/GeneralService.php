<?php


namespace BestThor\ScrappingMaster\Infrastructure\Service;

use BestThor\ScrappingMaster\Domain\ElementDetailContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralEmptyException;
use BestThor\ScrappingMaster\Domain\General\GeneralServiceInterface;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;

/**
 * Class GeneralService
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Service
 * @author  Ismael Moral <jastertdc@gmail.com
 */
final class GeneralService implements GeneralServiceInterface
{

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * @var ElementGeneralParser
     */
    protected $elementGeneralParser;

    /**
     * @var ElementDetailParser
     */
    protected $elementDetailParser;

    /**
     * @var ElementDownloadParser
     */
    protected $elementDownloadParser;

    /**
     * GeneralService constructor.
     *
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param ElementGeneralParser $elementGeneralParser
     * @param ElementDetailParser $elementDetailParser
     * @param ElementDownloadParser $elementDownloadParser
     */
    public function __construct(
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        ElementGeneralParser $elementGeneralParser,
        ElementDetailParser $elementDetailParser,
        ElementDownloadParser $elementDownloadParser
    ) {
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->elementGeneralParser = $elementGeneralParser;
        $this->elementDetailParser = $elementDetailParser;
        $this->elementDownloadParser = $elementDownloadParser;
    }

    /**
     * @param int $page
     *
     * @return ElementGeneralCollection
     * @throws ElementGeneralContentEmptyException
     * @throws ElementGeneralEmptyException
     */
    public function getElementGeneralByPage(
        int $page
    ) : ElementGeneralCollection {
        $elementGeneralContent = $this
            ->mtContentReaderRepository
            ->getElementGeneralContent($page);

        $this
            ->elementGeneralParser
            ->setContent($elementGeneralContent);

        $elementGeneralCollection = $this
            ->elementGeneralParser
            ->getElementGeneral();

        $finalElementGeneralCollection = new ElementGeneralCollection();

        /** @var ElementGeneral $elementGeneral */
        foreach ($elementGeneralCollection as $elementGeneral) {
            try {
                $elementDetailContent = $this
                    ->mtContentReaderRepository
                    ->getElementDetailContent(
                        $elementGeneral->getElementLink()
                    );

                $this
                    ->elementDetailParser
                    ->setContent($elementDetailContent);

                $elementDetail = $this
                    ->elementDetailParser
                    ->getElementDetail();

                $elementGeneral->setElementDetail($elementDetail);
            } catch (ElementDetailContentEmptyException $e) {
            }

            try {
                $elementDownloadContent = $this
                    ->mtContentReaderRepository
                    ->getElementDownloadContent(
                        $elementGeneral->getElementId()
                    );

                $this
                    ->elementDownloadParser
                    ->setContent($elementDownloadContent);

                $elementDownload = $this
                    ->elementDownloadParser
                    ->getElementDownload();

                $elementGeneral->setElementDownload($elementDownload);
            } catch (ElementDownloadContentEmptyException $e) {
            }

            $finalElementGeneralCollection->add(
                $elementGeneral
            );
        }

        return $finalElementGeneralCollection;
    }
}
