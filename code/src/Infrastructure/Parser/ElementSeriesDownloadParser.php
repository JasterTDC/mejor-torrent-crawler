<?php


namespace BestThor\ScrappingMaster\Infrastructure\Parser;

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
     * ElementSeriesDetailDownloadParser constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML($this->content, LIBXML_NOERROR);

        $this->domXPath = new \DOMXPath($this->domDocument);
    }

    /**
     * @return array|null
     */
    public function getElementSeriesDownload() : ?array
    {
        $iNodeList = $this->domXPath->query('//i');

        if (empty($iNodeList)) {
            return null;
        }

        return [
            'torrentName' => $iNodeList->item(0)->nodeValue
        ];
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->content      = null;
        $this->domXPath     = null;
        $this->domDocument  = null;
    }
}
