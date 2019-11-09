<?php


namespace BestThor\ScrappingMaster\Infrastructure\Parser;

/**
 * Class ElementSeriesDetailParser
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailParser
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
     * ElementSeriesDetailParser constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $content
     */
    public function setContent(
        string $content
    ) {
        $this->content = $content;

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTML($this->content, LIBXML_NOERROR);

        $this->domXPath = new \DOMXPath($this->domDocument);
    }

    /**
     * @return array|null
     */
    public function getElementDetail() : ?array
    {
        $linkNodeList = $this->domXPath->query('//a');

        if (empty($linkNodeList)) {
            return null;
        }

        $detailArr              = [];
        $detailArr['episodes']  = [];

        $imageNode = $this
            ->domXPath
            ->query('//img[@width="120"]');

        if ($imageNode->length > 0) {
            $imageUrl = $imageNode
                ->item(0)
                ->attributes
                ->getNamedItem('src')
                ->nodeValue;

            preg_match(
                '/\/(?<imageName>[^\/]+$)/',
                $imageUrl,
                $imgMatch
            );

            $detailArr['imageUrl']  = $imageUrl;
            $detailArr['imageName'] = $imgMatch['imageName'];
        }

        $descriptionContainer = $this
            ->domXPath
            ->query('//div[@align="justify"]');

        if (!empty($descriptionContainer) &&
            !empty($descriptionContainer->item(0))
        ) {
            $detailArr['description'] = $descriptionContainer
                ->item(0)
                ->nodeValue;
        }

        for ($i = 0; $i < $linkNodeList->length; $i++) {
            $href = $linkNodeList
                ->item($i)
                ->attributes
                ->getNamedItem('href')
                ->nodeValue;

            if (preg_match(
                '/serie\-episodio\-descargar\-torrent\-(?<episodeId>\d+)\-(?<episodeName>.+)\.html/',
                $href,
                $match
            )) {
                $detailArr['episodes'][] = [
                    'link'      => $href,
                    'episodeId' => (int) $match['episodeId'],
                    'name'      => $match['episodeName']
                ];
            }
        }

        return $detailArr;
    }

    /**
     * Destruct
     */
    public function __destruct()
    {
        $this->content      = null;
        $this->domXPath     = null;
        $this->domDocument  = null;
    }
}