<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Parser;

use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\DownloadTorrentUrlMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralDownloadHtmlMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementGeneralDownloadParserTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralDownloadParserTest extends TestCase
{

    /** @var ElementDownloadParser  */
    protected ElementDownloadParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ElementDownloadParser(
            new ElementDownloadFactory(
                DownloadTorrentUrlMother::random()
            )
        );
    }

    public function testValidDownload(): void
    {
        $this
            ->parser
            ->setContent(
                ElementGeneralDownloadHtmlMother::random()
            );

        $elementDownload = $this
            ->parser
            ->getElementDownload();

        $this->assertIsString(
            $elementDownload->getElementDownloadName()
        );
        $this->assertIsString(
            $elementDownload->getElementDownloadTorrentUrl()
        );
    }

    public function testDownloadWithoutName(): void
    {
        $this
            ->parser
            ->setContent(
                ElementGeneralDownloadHtmlMother::createWithoutName()
            );

        $elementDownload = $this
            ->parser
            ->getElementDownload();

        $this->assertNull(
            $elementDownload->getElementDownloadName()
        );
        $this->assertNull(
            $elementDownload->getElementDownloadTorrentUrl()
        );
    }
}
