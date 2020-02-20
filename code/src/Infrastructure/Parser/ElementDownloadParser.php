<?php

namespace BestThor\ScrappingMaster\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\ElementDownload;
use BestThor\ScrappingMaster\Domain\ElementDownloadFactoryInterface;
use BestThor\ScrappingMaster\Domain\ElementDownloadParserInterface;

/**
 * Class ElementDownloadParser
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDownloadParser implements ElementDownloadParserInterface
{
    /**
     * @var \DOMDocument
     */
    protected $domDoc;

    /**
     * @var \DOMXPath
     */
    protected $domXPath;

    /**
     * @var ElementDownloadFactoryInterface
     */
    protected $elementDownloadFactory;

    /**
     * @var string
     */
    protected $content;

    /**
     * ElementDownloadParser constructor.
     *
     * @param ElementDownloadFactoryInterface $elementDownloadFactory
     */
    public function __construct(
        ElementDownloadFactoryInterface $elementDownloadFactory
    ) {
        $this->elementDownloadFactory = $elementDownloadFactory;
    }

    /**
     * @param string $content
     */
    public function setContent(
        string $content
    ): void {
        $this->content = $content;

        $this->domDoc = new \DOMDocument();
        $this->domDoc->loadHTML($content, LIBXML_NOERROR);

        $this->domXPath = new \DOMXPath($this->domDoc);
    }

    /**
     * @return ElementDownload
     */
    public function getElementDownload(): ElementDownload
    {
        $ret = [];

        $downloadTorrentNameContainer = $this
            ->domXPath
            ->query('//i');

        if (
            !empty($downloadTorrentNameContainer) &&
            !empty($downloadTorrentNameContainer->item(0))
        ) {
            $ret['downloadName'] = $downloadTorrentNameContainer
                ->item(0)
                ->nodeValue;
        }

        $elementDownload = $this
            ->elementDownloadFactory
            ->createFromRaw($ret);

        if (!empty($elementDownload)) {
            return $elementDownload;
        }

        return new ElementDownload(
            null,
            null
        );
    }
}
