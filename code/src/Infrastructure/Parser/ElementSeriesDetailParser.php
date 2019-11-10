<?php


namespace BestThor\ScrappingMaster\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDescription;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesImage;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesImageFactory;

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
     * @var ElementSeriesImageFactory
     */
    protected $elementSeriesImageFactory;

    /**
     * @var ElementSeriesDetailFactory
     */
    protected $elementSeriesDetailFactory;

    /**
     * ElementSeriesDetailParser constructor.
     *
     * @param ElementSeriesImageFactory $elementSeriesImageFactory
     * @param ElementSeriesDetailFactory $elementSeriesDetailFactory
     */
    public function __construct(
        ElementSeriesImageFactory $elementSeriesImageFactory,
        ElementSeriesDetailFactory $elementSeriesDetailFactory
    ) {
        $this->elementSeriesImageFactory    = $elementSeriesImageFactory;
        $this->elementSeriesDetailFactory   = $elementSeriesDetailFactory;
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
     * @return ElementSeriesDetailCollection|null
     */
    public function getElementDetail() : ?ElementSeriesDetailCollection
    {
        $linkNodeList = $this->domXPath->query('//a');

        if (empty($linkNodeList) ||
            empty($linkNodeList->length)
        ) {
            return null;
        }

        $detailArr = [];

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
                $detailArr[] = [
                    'link'      => $href,
                    'id'        => (int) $match['episodeId'],
                    'name'      => $match['episodeName']
                ];
            }
        }

        return $this
            ->elementSeriesDetailFactory
            ->createFromRawCollection($detailArr);
    }

    /**
     * @return ElementSeriesDescription|null
     */
    public function getElementSeriesDescription() : ?ElementSeriesDescription
    {
        $descriptionContainer = $this
            ->domXPath
            ->query('//div[@align="justify"]');

        if (!empty($descriptionContainer) &&
            !empty($descriptionContainer->item(0))
        ) {
            return new ElementSeriesDescription(
                $descriptionContainer->item(0)->nodeValue
            );
        }

        return null;
    }

    /**
     * @return ElementSeriesImage|null
     */
    public function getElementSeriesImage() : ?ElementSeriesImage
    {
        $imageNode = $this
            ->domXPath
            ->query('//img[@width="120"]');

        if (!empty($imageNode) &&
            !empty($imageNode->item(0))
        ) {
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

            return $this
                ->elementSeriesImageFactory
                ->createFromRaw([
                    'imageUrl'  => $imageUrl,
                    'imageName' => $imgMatch['imageName']
                ]);
        }

        return null;
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