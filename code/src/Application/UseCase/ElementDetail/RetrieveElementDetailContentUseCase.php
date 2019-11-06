<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDetail;

use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;

/**
 * Class RetrieveElementDetailContentUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementDetail
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDetailContentUseCase
{

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * @var string
     */
    protected $detailFilePath;

    /**
     * RetrieveElementDetailContentUseCase constructor.
     *
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param string $detailFilePath
     */
    public function __construct(
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        string $detailFilePath
    ) {
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->detailFilePath = $detailFilePath;
    }

    /**
     * @param RetrieveElementDetailContentUseCaseArguments $arguments
     *
     * @return RetrieveElementDetailContentUseCaseResponse
     */
    public function handle(
        RetrieveElementDetailContentUseCaseArguments $arguments
    ) : RetrieveElementDetailContentUseCaseResponse {
        $filename = $this->detailFilePath .
            $arguments->getElementGeneral()->getElementId() .
            '.scrap.html';

        $content = '';

        try {
            if (is_file($filename)) {
                $current = new \DateTimeImmutable();
                $updated = new \DateTimeImmutable();
                $updated = $updated->setTimestamp(filemtime($filename));

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
                    ->getElementDetailContent(
                        $arguments
                            ->getElementGeneral()
                            ->getElementLink()
                    );

                file_put_contents(
                    $filename,
                    $content
                );
            }

            return new RetrieveElementDetailContentUseCaseResponse(
                true,
                $content,
                null
            );
        } catch (\Exception $e) {
            return new RetrieveElementDetailContentUseCaseResponse(
                false,
                null,
                $e->getMessage()
            );
        }
    }
}
