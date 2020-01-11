<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagFactoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagWriterRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagSaveException;

/**
 * Class GetTagFromGeneralUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagFromGeneralUseCase
{

    /**
     * Elements per page
     */
    const ELEMENTS_PER_PAGE = 50;

    /**
     * @var ElementGeneralReaderRepositoryInterface
     */
    protected $generalReaderRepository;

    /**
     * @var TagWriterRepositoryInterface
     */
    protected $tagWriterRepository;

    /**
     * @var TagReaderRepositoryInterface
     */
    protected $tagReaderRepository;

    /**
     * @var TagFactoryInterface
     */
    protected $tagFactory;

    /**
     * GetTagFromGeneralUseCase constructor.
     *
     * @param ElementGeneralReaderRepositoryInterface $generalReaderRepository
     * @param TagWriterRepositoryInterface $tagWriterRepository
     * @param TagReaderRepositoryInterface $tagReaderRepository
     * @param TagFactoryInterface $tagFactory
     */
    public function __construct(
        ElementGeneralReaderRepositoryInterface $generalReaderRepository,
        TagWriterRepositoryInterface $tagWriterRepository,
        TagReaderRepositoryInterface $tagReaderRepository,
        TagFactoryInterface $tagFactory
    ) {
        $this->generalReaderRepository = $generalReaderRepository;
        $this->tagWriterRepository = $tagWriterRepository;
        $this->tagReaderRepository = $tagReaderRepository;
        $this->tagFactory = $tagFactory;
    }


    /**
     * @return GetTagFromGeneralUseCaseResponse
     */
    public function handle() : GetTagFromGeneralUseCaseResponse
    {
        $generalTotal = $this
            ->generalReaderRepository
            ->getTotal();

        $totalPages = ceil($generalTotal/self::ELEMENTS_PER_PAGE);

        for ($i = 1; $i <= $totalPages; $i++) {
            $elementGeneralCollection = $this
                ->generalReaderRepository
                ->getElementGeneralByPage(
                    $i,
                    self::ELEMENTS_PER_PAGE
                );

            /** @var ElementGeneral $elementGeneral */
            foreach ($elementGeneralCollection as $elementGeneral) {
                preg_match_all('/(?<tags>[^\-]+)/',
                    $elementGeneral
                        ->getElementDetail()
                        ->getElementGenre(),
                    $match
                );

                if (is_array($match['tags']) && !empty($match['tags'])) {
                    $this->saveTagCollection($match['tags']);
                }
            }
        }

        return new GetTagFromGeneralUseCaseResponse(true);
    }

    /**
     * @param array $rawTagCollection
     *
     * @throws TagSaveException
     */
    protected function saveTagCollection (array $rawTagCollection)
    {
        $current = new \DateTimeImmutable();

        foreach ($rawTagCollection as $rawTag) {
            $tagFound = $this
                ->tagReaderRepository
                ->findByName($rawTag);

            if (empty($tagFound)) {
                $tagArr = [
                    'name'      => $rawTag,
                    'createdAt' => $current->format('Y-m-d H:i:s'),
                    'updatedAt' => $current->format('Y-m-d H:i:s')
                ];

                $this
                    ->tagWriterRepository
                    ->persist(
                        $this->tagFactory->createTagFromRaw($tagArr)
                    );
            }
        }
    }
}
