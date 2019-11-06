<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;

/**
 * Class RetrieveElementGeneralContentUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralContentUseCase
{

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * RetrieveElementGeneralContentUseCase constructor.
     *
     * @param string $filePath
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     */
    public function __construct(
        string $filePath,
        MTContentReaderRepositoryInterface $mtContentReaderRepository
    ) {
        $this->filePath = $filePath;
        $this->mtContentReaderRepository = $mtContentReaderRepository;
    }

    /**
     * @param RetrieveElementGeneralContentUseCaseArguments $arguments
     *
     * @return RetrieveElementGeneralContentUseCaseResponse
     */
    public function handle(
        RetrieveElementGeneralContentUseCaseArguments $arguments
    ) : RetrieveElementGeneralContentUseCaseResponse {
        $filename   = $this->filePath . $arguments->getPage() . '.scrap.html';
        $content    = '';

        try {
            if (is_file($filename)) {
                $updatedDate = new \DateTimeImmutable();

                if (!empty(filemtime($filename))) {
                    $updatedDate    = new \DateTimeImmutable();
                    $updatedDate    = $updatedDate->setTimestamp(filemtime($filename));
                }

                $current    = new \DateTimeImmutable();
                $interval   = $current->diff($updatedDate);

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
                    ->getElementGeneralContent(
                        $arguments->getPage()
                    );

                file_put_contents(
                    $filename,
                    $content
                );
            }

            return new RetrieveElementGeneralContentUseCaseResponse(
                true,
                $content,
                null
            );
        } catch (\Exception $e) {
            return new RetrieveElementGeneralContentUseCaseResponse(
                false,
                null,
                $e->getMessage()
            );
        }
    }
}
