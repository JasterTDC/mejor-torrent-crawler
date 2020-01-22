<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementDownloadFileEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralPersistException;
use BestThor\ScrappingMaster\Domain\ElementGeneralWriterRepositoryInterface;
use BestThor\ScrappingMaster\Domain\ElementImageEmptyException;
use BestThor\ScrappingMaster\Domain\General\GeneralServiceInterface;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\GeneralTagFactoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\GeneralTagWriterRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagFactoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagSaveException;
use BestThor\ScrappingMaster\Domain\Tag\TagSearchException;
use BestThor\ScrappingMaster\Domain\Tag\TagWriterRepositoryInterface;

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
     * @var TagReaderRepositoryInterface
     */
    protected $tagReaderRepository;

    /**
     * @var TagWriterRepositoryInterface
     */
    protected $tagWriterRepository;

    /**
     * @var GeneralTagWriterRepositoryInterface
     */
    protected $generalTagWriterRepository;

    /**
     * @var GeneralTagFactoryInterface
     */
    protected $generalTagFactory;

    /**
     * @var TagFactoryInterface
     */
    protected $tagFactory;

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
     * @param TagReaderRepositoryInterface $tagReaderRepository
     * @param TagWriterRepositoryInterface $tagWriterRepository
     * @param GeneralTagWriterRepositoryInterface $generalTagWriterRepository
     * @param GeneralTagFactoryInterface $generalTagFactory
     * @param TagFactoryInterface $tagFactory
     * @param string $staticImageDir
     * @param string $staticTorrentDir
     */
    public function __construct(
        GeneralServiceInterface $generalService,
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        ElementGeneralWriterRepositoryInterface $elementGeneralWriter,
        TagReaderRepositoryInterface $tagReaderRepository,
        TagWriterRepositoryInterface $tagWriterRepository,
        GeneralTagWriterRepositoryInterface $generalTagWriterRepository,
        GeneralTagFactoryInterface $generalTagFactory,
        TagFactoryInterface $tagFactory,
        string $staticImageDir,
        string $staticTorrentDir
    ) {
        $this->generalService = $generalService;
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->elementGeneralWriter = $elementGeneralWriter;
        $this->tagReaderRepository = $tagReaderRepository;
        $this->tagWriterRepository = $tagWriterRepository;
        $this->generalTagWriterRepository = $generalTagWriterRepository;
        $this->generalTagFactory = $generalTagFactory;
        $this->tagFactory = $tagFactory;
        $this->staticImageDir = $staticImageDir;
        $this->staticTorrentDir = $staticTorrentDir;
    }

    /**
     * @param GetElementGeneralCollectionArguments $arguments
     *
     * @return GetElementGeneralCollectionUseCaseResponse
     * @throws ElementGeneralContentEmptyException
     * @throws ElementGeneralEmptyException
     * @throws ElementGeneralPersistException
     * @throws ElementImageEmptyException
     * @throws TagSaveException
     * @throws TagSearchException
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
                        !empty($elementGeneral->getElementDetail()->getElementCoverImg()) &&
                        !empty($elementGeneral->getElementDetail()->getElementCoverImgName())
                    ) {
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

                            $this
                                ->elementGeneralWriter
                                ->persist($elementGeneral);
                        } catch (ElementDownloadContentEmptyException $e) {
                        }
                    }

                    if (!empty($elementGeneral->getElementDetail()->getElementGenre())) {
                        preg_match_all(
                            '/(?<tags>[^\-]+)/',
                            $elementGeneral->getElementDetail()->getElementGenre(),
                            $match
                        );

                        if (!empty($match['tags']) &&
                            $match['tags'] === (array) $match['tags']
                        ) {
                            $this->saveTagCollection(
                                $match['tags'],
                                $elementGeneral
                            );
                        }
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
     * @throws ElementGeneralContentEmptyException
     * @throws ElementGeneralEmptyException
     */
    protected function getElementGeneralCollection(
        int $page
    ) : ?ElementGeneralCollection {
        return $this
            ->generalService
            ->getElementGeneralByPage(
                $page
            );
    }

    /**
     * @param array $rawTagCollection
     * @param ElementGeneral $elementGeneral
     *
     * @throws TagSaveException
     * @throws TagSearchException
     */
    protected function saveTagCollection(
        array $rawTagCollection,
        ElementGeneral $elementGeneral
    ) {
        $current = new \DateTimeImmutable();

        foreach ($rawTagCollection as $rawTag) {
            $tag = $this
                ->tagReaderRepository
                ->findByName($rawTag);

            if (empty($tag)) {
                $tagArr = [
                    'name'      => $rawTag,
                    'createdAt' => $current->format('Y-m-d H:i:s'),
                    'updatedAt' => $current->format('Y-m-d H:i:s')
                ];

                $tag = $this
                    ->tagWriterRepository
                    ->persist(
                        $this->tagFactory->createTagFromRaw($tagArr)
                    );
            }

            $this
                ->generalTagWriterRepository
                ->persist(
                    $this
                        ->generalTagFactory
                        ->createFromRaw([
                            'generalId'     => $elementGeneral->getElementId(),
                            'tagId'         => $tag->getId(),
                            'createdAt'     => $current->format('Y-m-d H:i:s'),
                            'updatedAt'     => $current->format('Y-m-d H:i:s')
                        ])
                );
        }
    }
}
