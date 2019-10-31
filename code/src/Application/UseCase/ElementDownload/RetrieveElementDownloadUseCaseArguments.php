<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDownload;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class RetrieveElementDownloadUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDownloadUseCaseArguments
{

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var ElementGeneral|null
     */
    protected $elementGeneral;

    /**
     * RetrieveElementDownloadUseCaseArguments constructor.
     *
     * @param string|null $content
     * @param ElementGeneral|null $elementGeneral
     */
    public function __construct(
        ?string $content,
        ?ElementGeneral $elementGeneral
    ) {
        $this->content = $content;
        $this->elementGeneral = $elementGeneral;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return ElementGeneral|null
     */
    public function getElementGeneral(): ?ElementGeneral
    {
        return $this->elementGeneral;
    }
}
