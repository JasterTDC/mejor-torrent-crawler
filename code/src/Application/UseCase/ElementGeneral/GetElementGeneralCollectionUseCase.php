<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralPersistException;
use BestThor\ScrappingMaster\Domain\ElementGeneralWriterRepositoryInterface;
use BestThor\ScrappingMaster\Domain\ElementImageEmptyException;
use BestThor\ScrappingMaster\Domain\General\GeneralServiceInterface;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;

/**
 * Class GetElementGeneralCollectionUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralCollectionUseCase
{
    /**
     * @var GeneralServiceInterface
     */
    protected $generalService;

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * @var ElementGeneralWriterRepositoryInterface
     */
    protected $elementGeneralWriter;

    /**
     * @var string
     */
    protected $staticImageDir;

    /**
     * @var string
     */
    protected $staticTorrentDir;

    /**
     * GetElementGeneralCollectionUseCase constructor.
     *
     * @param GeneralServiceInterface $generalService
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param ElementGeneralWriterRepositoryInterface $elementGeneralWriter
     * @param string $staticImageDir
     * @param string $staticTorrentDir
     */
    public function __construct(
        GeneralServiceInterface $generalService,
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        ElementGeneralWriterRepositoryInterface $elementGeneralWriter,
        string $staticImageDir,
        string $staticTorrentDir
    ) {
        $this->generalService = $generalService;
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->elementGeneralWriter = $elementGeneralWriter;
        $this->staticImageDir = $staticImageDir;
        $this->staticTorrentDir = $staticTorrentDir;
    }

    /**
     * @param GetElementGeneralCollectionArguments $arguments
     *
     * @return GetElementGeneralCollectionUseCaseResponse
     */
    public function handle(
        GetElementGeneralCollectionArguments $arguments
    ) : GetElementGeneralCollectionUseCaseResponse {
        for ($i = 1; $i < $arguments->getTotalPages(); $i++) {
            $elementGeneralCollection = $this->getElementGeneralCollection($i);

            if (!empty($elementGeneralCollection)) {
                /** @var ElementGeneral $elementGeneral */
                foreach ($elementGeneralCollection as $elementGeneral) {
                    if (!empty($elementGeneral->getElementDetail()) &&
                        !empty($elementGeneral->getElementDetail()->getElementCoverImg())
                    ) {
                        try {
                            $imageContent = $this
                                ->mtContentReaderRepository
                                ->getElementImageFile(
                                    $elementGeneral
                                        ->getElementDetail()
                                        ->getElementCoverImg()
                                );

                            if (preg_match(
                                '/(?<imageExtension>\.[^$]+)/',
                                $elementGeneral->getElementDetail()->getElementCoverImgName(),
                                $imageExtension
                            )) {
                                file_put_contents(
                                    $this->staticImageDir .
                                    $elementGeneral->getElementId() .
                                    $imageExtension['imageExtension'],
                                    $imageContent
                                );
                            }
                        } catch (ElementImageEmptyException $e) {
                        }
                    }

                    if (!empty($elementGeneral->getElementDownload()) &&
                        !empty($elementGeneral->getElementDownload()->getElementDownloadName()) &&
                        !empty($elementGeneral->getElementDownload()->getElementDownloadTorrentUrl())
                    ) {
                        if (!is_dir($this->staticTorrentDir)) {
                            mkdir($this->staticTorrentDir);
                        }

                        try {
                            $downloadContent = $this
                                ->mtContentReaderRepository
                                ->getElementDownloadFile(
                                    $elementGeneral
                                        ->getElementDownload()
                                        ->getElementDownloadTorrentUrl()
                                );

                            file_put_contents(
                                $this->staticTorrentDir .
                                $elementGeneral->getElementId() .
                                '.torrent',
                                $downloadContent
                            );
                        } catch (ElementDownloadContentEmptyException $e) {
                        }
                    }

                    try {
                        $this
                            ->elementGeneralWriter
                            ->persist($elementGeneral);
                    } catch (ElementGeneralPersistException $e) {
                    }
                }
            }
        }

        return new GetElementGeneralCollectionUseCaseResponse(
            true,
            null
        );
    }

    /**
     * @param int $page
     *
     * @return ElementGeneralCollection|null
     */
    protected function getElementGeneralCollection(
        int $page
    ) : ?ElementGeneralCollection {
        try {
            return $this
                ->generalService
                ->getElementGeneralByPage(
                    $page
                );
        } catch (\Exception $e) {
            return null;
        }
    }
}
