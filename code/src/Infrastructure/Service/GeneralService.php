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
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * GeneralService constructor.
     *
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param ElementGeneralParser $elementGeneralParser
     * @param ElementDetailParser $elementDetailParser
     * @param ElementDownloadParser $elementDownloadParser
     * @param LoggerInterface $logger
     */
    public function __construct(
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        ElementGeneralParser $elementGeneralParser,
        ElementDetailParser $elementDetailParser,
        ElementDownloadParser $elementDownloadParser,
        LoggerInterface $logger
    ) {
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->elementGeneralParser = $elementGeneralParser;
        $this->elementDetailParser = $elementDetailParser;
        $this->elementDownloadParser = $elementDownloadParser;
        $this->logger = $logger;
    }

    /**
     * @param int $page
     *
     * @return ElementGeneralCollection
     * @throws ElementDetailContentEmptyException
     * @throws ElementDownloadContentEmptyException
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

            $finalElementGeneralCollection->add(
                $elementGeneral
            );

            $this
                ->logger
                ->info("[General][{$elementGeneral->getElementId()}] {$elementGeneral->getElementName()}");
        }

        return $finalElementGeneralCollection;
    }
}
