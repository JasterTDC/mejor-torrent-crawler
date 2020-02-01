<?php

namespace BestThor\ScrappingMaster\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralFactoryInterface;
use BestThor\ScrappingMaster\Domain\ElementGeneralParserInterface;

/**
 * Class ElementGeneralParser
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralParser implements ElementGeneralParserInterface
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
     * @var ElementGeneralFactoryInterface
     */
    protected $elementGeneralFactory;

    /**
     * @var string
     */
    protected $content;

    /**
     * ElementGeneralParser constructor.
     *
     * @param ElementGeneralFactoryInterface $elementGeneralFactory
     */
    public function __construct(
        ElementGeneralFactoryInterface $elementGeneralFactory
    ) {
        $this->elementGeneralFactory = $elementGeneralFactory;
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
     * @return ElementGeneralCollection
     *
     * @throws ElementGeneralEmptyException
     */
    public function getElementGeneral(): ElementGeneralCollection
    {
        $rawElementGeneralCollection = [];

        $elementGeneralRaw = $this->domXPath->query('//a');

        if (empty($elementGeneralRaw)) {
            throw new ElementGeneralEmptyException(
                'We could not find the main link element',
                0
            );
        }

        for ($i = 0; $i < $elementGeneralRaw->length; $i++) {
            $hrefLink = null;

            if (!empty($elementGeneralRaw->item($i))) {
                $hrefLink = $elementGeneralRaw
                    ->item($i)
                    ->attributes
                    ->getNamedItem('href');
            }

            if (!empty($hrefLink)) {
                $match = [];

                if (
                    preg_match(
                        '/\/peli\-descargar\-torrent\-(?<elementId>\d+)\-(?<elementSlug>.*)\.html/',
                        $hrefLink->textContent,
                        $match
                    )
                ) {
                    $rawElement = [
                        'id'     => $match['elementId'],
                        'slug'   => $match['elementSlug'],
                        'link'   => $hrefLink->textContent,
                        'name'   => preg_replace('/\-/', ' ', $match['elementSlug'])
                    ];

                    $rawElementGeneralCollection[] = $rawElement;
                }
            }
        }

        if (empty($rawElementGeneralCollection)) {
            throw new ElementGeneralEmptyException(
                'We could not find any interesting element',
                2
            );
        }

        return $this
            ->elementGeneralFactory
            ->createFromRawElementGeneralCollection(
                $rawElementGeneralCollection
            );
    }
}
