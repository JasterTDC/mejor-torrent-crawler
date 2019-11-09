<?php


namespace BestThor\ScrappingMaster\Infrastructure\Parser;

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
     * ElementSeriesParser constructor.
     */
    public function __construct()
    {
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

    public function getElementSeries() : ?array
    {
        $linkNodeList = $this
            ->domXPath
            ->query('//a');

        if (empty($linkNodeList)) {
            return null;
        }

        $seriesArr = [];

        if (!empty($imageNode)) {
            $seriesArr['imageUrl'] = $imageNode
                ->item(0)
                ->attributes
                ->getNamedItem('src')
                ->nodeValue;
        }

        for($i = 0; $i < $linkNodeList->length; $i++) {
            $href = $linkNodeList
                ->item($i)
                ->attributes
                ->getNamedItem('href')
                ->nodeValue;

            if (preg_match(
                '/\/serie\-descargar\-torrents\-(?<elementFirstId>\d+)\-(?<elementSecondId>\d+)\-(?<elementName>.+)\.html$/',
                $href,
                $match
            )) {
                $seriesArr[] = [
                    'link'      => $href,
                    'firstId'   => (int) $match['elementFirstId'],
                    'secondId'  => (int) $match['elementSecondId'],
                    'slug'      => $match['elementName'],
                    'name'      => preg_replace(
                        '/\-/',
                        ' ',
                        (string) $match['elementName']
                    )
                ];
            }
        }

        return $seriesArr;
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
