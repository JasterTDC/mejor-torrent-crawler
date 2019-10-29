<?php


namespace BestThor\ScrappingMaster\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\ElementDetail;
use BestThor\ScrappingMaster\Domain\ElementDetailFactoryInterface;
use BestThor\ScrappingMaster\Domain\ElementDetailParserInterface;

/**
 * Class ElementDetailParser
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailParser implements ElementDetailParserInterface
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
     * @var ElementDetailFactoryInterface
     */
    protected $elementDetailFactory;

    /**
     * @var string
     */
    protected $content;

    /**
     * ElementDetailParser constructor.
     *
     * @param ElementDetailFactoryInterface $elementDetailFactory
     */
    public function __construct(
        ElementDetailFactoryInterface $elementDetailFactory
    ) {
        $this->elementDetailFactory = $elementDetailFactory;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        $this->domDoc = new \DOMDocument();
        $this->domDoc->loadHTML($content, LIBXML_NOERROR);

        $this->domXPath = new \DOMXPath($this->domDoc);
    }

    /**
     * @return ElementDetail
     */
    public function getElementDetail() : ElementDetail
    {
        $elementDetail = [];

        $centerContainer = $this
            ->domXPath
            ->query('//table[@align="center"]');

        $coverImg = $this
            ->domXPath
            ->query('//img[@width="120"]');

        if (!empty($coverImg)) {
            $coverImgNode = $coverImg
                ->item(0);

            if (!empty($coverImgNode)) {
                $imgMatch = [];

                if (!empty($coverImgNode->attributes->getNamedItem('src'))) {
                    $elementDetail['elementCoverImg'] = $coverImgNode
                        ->attributes
                        ->getNamedItem('src')
                        ->nodeValue;

                    preg_match(
                        '/\/(?<elementCoverImgName>[^\/]+$)/',
                        $elementDetail['elementCoverImg'],
                        $imgMatch
                    );

                    $elementDetail['elementCoverImgName'] = $imgMatch['elementCoverImgName'];
                }
            }
        }

        if (!empty($centerContainer) &&
            !empty($centerContainer->item(0))
        ) {
            $elementGeneralInfo = $centerContainer->item(0)->nodeValue;

            $elementDetail['elementGenre'] = $this->getElementGenre(
                $elementGeneralInfo
            );

            $elementDetail['elementDescription'] = $this->getElementDescription(
                $elementGeneralInfo
            );

            $elementDetail['elementFormat'] = $this->getElementFormat(
                $elementGeneralInfo
            );

            $elementDetail['elementPublishedDate'] = $this->getElementPublishedDate(
                $elementGeneralInfo
            );
        }

        return $this
            ->elementDetailFactory
            ->createElementDetailFromRaw($elementDetail);
    }

    /**
     * @param string $rawText
     *
     * @return string|null
     */
    protected function getElementGenre(
        string $rawText
    ) : ?string {
        $elementGenre = [];

        preg_match(
            '/Género\:(?<elementGenre>[^\.]+)/',
            $rawText,
            $elementGenre
        );

        if (empty($elementGenre['elementGenre'])) {
            return null;
        }

        $elementGenre = str_replace(
            chr(160),
            '',
            $elementGenre['elementGenre']
        );

        $elementGenre = str_replace(
            chr(194),
            '',
            $elementGenre
        );

        $elementGenre = preg_replace(
            '/\s/',
            '',
            $elementGenre
        );

        return $elementGenre;
    }

    /**
     * @param string $rawText
     *
     * @return string|null
     */
    protected function getElementDescription(
        string $rawText
    ) : ?string {
        $elementDescription = [];

        preg_match(
            '/Descripción\:(?<elementDescription>[^.]+)/',
            $rawText,
            $elementDescription
        );

        if (empty($elementDescription['elementDescription'])) {
            return null;
        }

        return trim($elementDescription['elementDescription']);
    }

    /**
     * @param string $rawText
     *
     * @return string|null
     */
    protected function getElementFormat(
        string $rawText
    ) : ?string {
        $elementFormat = [];

        preg_match(
            '/Formato\:(?<elementFormat>.*[^\s])/',
            $rawText,
            $elementFormat
        );

        if (empty($elementFormat['elementFormat'])) {
            return null;
        }

        $elementFormatStr = str_replace(
            chr(160),
            '',
            (string) $elementFormat['elementFormat']
        );
        $elementFormatStr = str_replace(
            chr(194),
            '',
            $elementFormatStr
        );
        $elementFormatStr = preg_replace(
            '/\s/',
            '',
            $elementFormatStr
        );

        return $elementFormatStr;
    }

    /**
     * @param string $rawText
     *
     * @return string|null
     */
    protected function getElementPublishedDate(
        string $rawText
    ) : ?string {
        $elementPublishedDate = [];

        preg_match(
            '/Fecha\:(?<elementDate>.*)/',
            $rawText,
            $elementPublishedDate
        );

        if (empty($elementPublishedDate['elementDate'])) {
            return null;
        }

        $elementPublishedDateStr = str_replace(
            chr(160),
            '',
            (string) $elementPublishedDate['elementDate']
        );

        $elementPublishedDateStr = str_replace(
            chr(194),
            '',
            $elementPublishedDateStr
        );

        $elementPublishedDateStr = preg_replace(
            '/\s/',
            '',
            $elementPublishedDateStr
        );

        return $elementPublishedDateStr;
    }
}
