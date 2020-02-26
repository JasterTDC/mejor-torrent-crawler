<?php

namespace BestThor\ScrappingMaster\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDownload;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesDownloadFactory;

/**
 * Class ElementSeriesDetailDownloadParser
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadParser
{
    /**
     * @var \DOMDocument
     */
    protected $domDocument;

    /**
     * @var \DOMXPath
     */
    protected $domXPath;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var ElementSeriesDownloadFactory
     */
    protected $elementSeriesDownloadFactory;

    /**
     * ElementSeriesDetailDownloadParser constructor.
     */
    public function __construct(
        ElementSeriesDownloadFactory $elementSeriesDownloadFactory
    ) {
        $this->elementSeriesDownloadFactory = $elementSeriesDownloadFactory;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML($this->content, LIBXML_NOERROR);

        $this->domXPath = new \DOMXPath($this->domDocument);
    }

    /**
     * @return ElementSeriesDownload|null
     */
    public function getElementSeriesDownload(): ?ElementSeriesDownload
    {
        $iNodeList = $this->domXPath->query('//i');

        if (
            empty($iNodeList) ||
            empty($iNodeList->length) ||
            empty($iNodeList->item(0)->nodeValue)
        ) {
            return null;
        }

        return $this
            ->elementSeriesDownloadFactory
            ->createFromRaw([
                'name' => $iNodeList->item(0)->nodeValue
            ]);
    }
}
