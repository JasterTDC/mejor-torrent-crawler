<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;

/**
 * Class GetElementUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementUseCaseResponse
{

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * @var ElementGeneralCollection|null
     */
    protected $elementGeneralCollection;

    /**
     * @var ElementSeriesCollection|null
     */
    protected $elementSeriesCollection;

    /**
     * GetElementUseCaseResponse constructor.
     *
     * @param bool $success
     * @param string|null $error
     * @param ElementGeneralCollection|null $elementGeneralCollection
     * @param ElementSeriesCollection|null $elementSeriesCollection
     */
    public function __construct(
        bool $success,
        ?string $error,
        ?ElementGeneralCollection $elementGeneralCollection,
        ?ElementSeriesCollection $elementSeriesCollection
    ) {
        $this->success = $success;
        $this->error = $error;
        $this->elementGeneralCollection = $elementGeneralCollection;
        $this->elementSeriesCollection = $elementSeriesCollection;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @return ElementGeneralCollection|null
     */
    public function getElementGeneralCollection(): ?ElementGeneralCollection
    {
        return $this->elementGeneralCollection;
    }

    /**
     * @return ElementSeriesCollection|null
     */
    public function getElementSeriesCollection(): ?ElementSeriesCollection
    {
        return $this->elementSeriesCollection;
    }
}
