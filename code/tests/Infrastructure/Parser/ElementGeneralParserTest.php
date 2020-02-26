<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Parser;

use BestThor\ScrappingMaster\Domain\General\ElementGeneralEmptyException;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\DownloadTorrentUrlMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralLinkRawCollectionMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementGeneralParserTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralParserTest extends TestCase
{
    /** @var ElementGeneralParser  */
    protected ElementGeneralParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ElementGeneralParser(
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    DownloadTorrentUrlMother::random()
                )
            )
        );
    }

    public function testIfContentContainsOnlyParagraph(): void
    {
        $this->expectException(ElementGeneralEmptyException::class);

        $this
            ->parser
            ->setContent('<p></p>');

        $this
            ->parser
            ->getElementGeneral();
    }

    public function testIfContentContainsLinkCollection(): void
    {
        $this
            ->parser
            ->setContent(ElementGeneralLinkRawCollectionMother::random());

        $elementGeneralCollection = $this
            ->parser
            ->getElementGeneral();

        $this->assertGreaterThan(1, $elementGeneralCollection->count());
    }

    public function testIfExpressionIsMalformed(): void
    {
        $this->expectException(ElementGeneralEmptyException::class);

        $this
            ->parser
            ->setContent('<p>');

        $mockHtmlRepository = \Mockery::mock(\DOMXPath::class);

        $mockHtmlRepository
            ->shouldReceive('query')
            ->with('//a')
            ->andReturn(false);

        $reflectionClass = new \ReflectionClass(ElementGeneralParser::class);
        $htmlRepository = $reflectionClass->getProperty('domXPath');
        $htmlRepository->setAccessible(true);
        $htmlRepository->setValue(
            $this->parser,
            $mockHtmlRepository
        );
        $htmlRepository->setAccessible(false);

        $this
            ->parser
            ->getElementGeneral();
    }
}
