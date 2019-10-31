<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

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
     * @var string
     */
    protected $staticImgDir;

    /**
     * SaveElementInFileUseCase constructor.
     *
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param string $staticImgDir
     */
    public function __construct(
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        string $staticImgDir
    ) {
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->staticImgDir = $staticImgDir;
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

            if (empty($elementGeneral->getElementDetail()) ||
                empty($elementGeneral->getElementDetail()->getElementDir()) ||
                empty($elementGeneral->getElementDetail()->getElementYearDir()) ||
                empty($elementGeneral->getElementDetail()->getElementMonthDir()) ||
                empty($elementGeneral->getElementDownload()) ||
                empty($elementGeneral->getElementDownload()->getElementDownloadTorrentUrl())
            ) {
                return new SaveElementInFileUseCaseResponse(false);
            }

            $content = $this
                ->mtContentReaderRepository
                ->getElementDownloadFile(
                    $elementGeneral
                        ->getElementDownload()
                        ->getElementDownloadTorrentUrl()
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

                preg_match(
                    '/(?<imageExtension>\.[^$]+)/',
                    $elementGeneral->getElementDetail()->getElementCoverImgName(),
                    $imageExtension
                );

                $imageFilePath = $elementGeneral
                        ->getElementDetail()
                        ->getElementDir() . DIRECTORY_SEPARATOR .
                    $elementGeneral
                        ->getElementDetail()
                        ->getElementCoverImgName();

                $staticImgPath = $this->staticImgDir .
                    $elementGeneral->getElementId() .
                    $imageExtension['imageExtension'];

                if (!is_file($imageFilePath)) {
                    file_put_contents(
                        $imageFilePath,
                        $imageContent
                    );
                }

                if (!is_file($staticImgPath)) {
                    file_put_contents(
                        $staticImgPath,
                        $imageContent
                    );
                }
            }

            $downloadFilePath = $elementGeneral
                ->getElementDetail()
                ->getElementDir() . DIRECTORY_SEPARATOR .
                $elementGeneral
                    ->getElementDownload()
                    ->getElementDownloadName();

            if (!is_file($downloadFilePath)) {
                file_put_contents(
                    $downloadFilePath,
                    $content
                );
            }

            return new SaveElementInFileUseCaseResponse(true);
        } catch (\Exception $e) {
            return new SaveElementInFileUseCaseResponse(false);
        }
    }
}
