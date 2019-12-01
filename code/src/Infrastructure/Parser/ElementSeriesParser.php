<?php


namespace BestThor\ScrappingMaster\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesFactory;

/**
 * Class ElementSeriesParser
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesParser
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
     * @var ElementSeriesFactory
     */
    protected $elementSeriesFactory;

    /**
     * ElementSeriesParser constructor.
     *
     * @param ElementSeriesFactory $elementSeriesFactory
     */
    public function __construct(
        ElementSeriesFactory $elementSeriesFactory
    ) {
        $this->elementSeriesFactory = $elementSeriesFactory;
    }

    /**
     * @param string $content
     */
    public function setContent(
        string $content
    ) : void {
        $this->content = $content;

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML($this->content, LIBXML_NOERROR);

        $this->domXPath = new \DOMXPath($this->domDocument);
    }

    /**
     * @return ElementSeriesCollection|null
     */
    public function getElementSeriesCollection() : ?ElementSeriesCollection
    {
        $linkNodeList = $this
            ->domXPath
            ->query('//a');

        if (empty($linkNodeList) ||
            empty($linkNodeList->length)
        ) {
            return null;
        }

        $seriesArr = [];

        for ($i = 0; $i < $linkNodeList->length; $i++) {
            $href = $linkNodeList
                ->item($i)
                ->attributes
                ->getNamedItem('href')
                ->nodeValue;

            if (preg_match(
                '/\/serie\-descargar\-torrents\-'.
                '(?<elementFirstId>\d+)\-(?<elementSecondId>\d+)\-(?<elementName>.+)\.html$/',
                $href,
                $match
            )) {
                $seriesArr[] = [
                    'link'      => $href,
                    'id'        => (int) $match['elementFirstId'],
                    'firstEpId' => (int) $match['elementSecondId'],
                    'slug'      => $match['elementName'],
                    'name'      => preg_replace(
                        '/\-/',
                        ' ',
                        (string) $match['elementName']
                    )
                ];
            }
        }

        return $this
            ->elementSeriesFactory
            ->createFromRawCollection($seriesArr);
    }

    /**
     * Destruct the entire class
     */
    public function __destruct()
    {
        $this->content      = null;
        $this->domXPath     = null;
        $this->domDocument  = null;
    }
}
