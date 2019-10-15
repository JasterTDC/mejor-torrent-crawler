<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;

/**
 * Class SaveElementInFileUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SaveElementInFileUseCase
{
    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * SaveElementInFileUseCase constructor.
     *
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     */
    public function __construct(
        MTContentReaderRepositoryInterface $mtContentReaderRepository
    ) {
        $this->mtContentReaderRepository = $mtContentReaderRepository;
    }

    /**
     * @param SaveElementInFileUseCaseArguments $arguments
     *
     * @return SaveElementInFileUseCaseResponse
     */
    public function handle(
        SaveElementInFileUseCaseArguments $arguments
    ) : SaveElementInFileUseCaseResponse {
        try {
            $elementGeneral = $arguments->getElementGeneral();

            $content = $this
                ->mtContentReaderRepository
                ->getElementDownloadFile(
                    $elementGeneral
                        ->getElementDownload()
                        ->getElementDownloadTorrentUrl()
                );

            $imageContent = $this
                ->mtContentReaderRepository
                ->getElementImageFile(
                    $elementGeneral
                        ->getElementDetail()
                        ->getElementCoverImg()
                );

            if (!is_dir($elementGeneral->getElementDetail()->getElementYearDir())) {
                mkdir($elementGeneral->getElementDetail()->getElementYearDir());
            }

            if (!is_dir($elementGeneral->getElementDetail()->getElementMonthDir())) {
                mkdir($elementGeneral->getElementDetail()->getElementMonthDir());
            }

            if (!is_dir($elementGeneral->getElementDetail()->getElementDir())) {
                mkdir($elementGeneral->getElementDetail()->getElementDir());
            }

            file_put_contents(
                $elementGeneral->getElementDetail()->getElementDir() . DIRECTORY_SEPARATOR .
                $elementGeneral->getElementDownload()->getElementDownloadName(),
                $content
            );

            file_put_contents(
                $elementGeneral->getElementDetail()->getElementDir() . DIRECTORY_SEPARATOR .
                $elementGeneral->getElementDetail()->getElementCoverImgName(),
                $imageContent
            );

            return new SaveElementInFileUseCaseResponse(true);
        } catch (\Exception $e) {
            return new SaveElementInFileUseCaseResponse(false);
        }
    }
}
