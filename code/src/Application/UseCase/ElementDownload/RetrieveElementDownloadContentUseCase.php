<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDownload;

use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailContentUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailContentUseCaseResponse;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;

/**
 * Class RetrieveElementDownloadContentUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementDownload
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDownloadContentUseCase
{
    /**
     * @var string
     */
    protected $downloadPath;

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * RetrieveElementDownloadContentUseCase constructor.
     *
     * @param string $downloadPath
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     */
    public function __construct(
        string $downloadPath,
        MTContentReaderRepositoryInterface $mtContentReaderRepository
    ) {
        $this->downloadPath = $downloadPath;
        $this->mtContentReaderRepository = $mtContentReaderRepository;
    }

    /**
     * @param RetrieveElementDownloadContentUseCaseArguments $arguments
     *
     * @return RetrieveElementDownloadContentUseCaseResponse
     */
    public function handle(
        RetrieveElementDownloadContentUseCaseArguments $arguments
    ) : RetrieveElementDownloadContentUseCaseResponse {
        $filename = $this->downloadPath .
            $arguments->getElementId() .
            '.scrap.html';

        $content = '';

        try {
            if (is_file($filename)) {
                $current    = new \DateTimeImmutable();
                $updated    = new \DateTimeImmutable();
                $updated    = $updated->setTimestamp(filemtime($filename));

                $interval = $current->diff($updated);

                $daysDiff = (int) $interval->format('%d');
                $hoursDiff = (int) $interval->format('%H') +
                    $daysDiff * 24;

                if ($hoursDiff < 4) {
                    $content = file_get_contents($filename);
                }
            }

            if (empty($content)) {
                $content = $this
                    ->mtContentReaderRepository
                    ->getElementDownloadContent($arguments->getElementId());

                file_put_contents(
                    $filename,
                    $content
                );
            }

            return new RetrieveElementDownloadContentUseCaseResponse(
                true,
                $content,
                null
            );
        } catch (\Exception $e) {
            return new RetrieveElementDownloadContentUseCaseResponse(
                false,
                null,
                $e->getMessage()
            );
        }
    }
}
