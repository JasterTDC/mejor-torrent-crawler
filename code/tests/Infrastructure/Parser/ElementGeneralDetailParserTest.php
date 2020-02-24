<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Parser;

use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralDetailRawMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementGeneralDetailParserTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Parser
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralDetailParserTest extends TestCase
{

    /** @var ElementDetailParser  */
    protected ElementDetailParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ElementDetailParser(
            new ElementDetailFactory()
        );
    }

    public function testValidDetail(): void
    {
        $this
            ->parser
            ->setContent(
                ElementGeneralDetailRawMother::random()
            );

        $elementDetail = $this->parser->getElementDetail();

        $this->assertIsString(
            $elementDetail->getElementGenre()
        );
        $this->assertIsString(
            $elementDetail->getElementFormat()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImg()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImgName()
        );
        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $elementDetail->getElementPublishedDate()
        );
    }

    public function testWithoutGenre(): void
    {
        $this
            ->parser
            ->setContent(
                ElementGeneralDetailRawMother::createWithoutGenre()
            );

        $elementDetail = $this->parser->getElementDetail();

        $this->assertNull(
            $elementDetail->getElementGenre()
        );
        $this->assertIsString(
            $elementDetail->getElementFormat()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImg()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImgName()
        );
        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $elementDetail->getElementPublishedDate()
        );
    }

    public function testWithoutFormat(): void
    {
        $this
            ->parser
            ->setContent(
                ElementGeneralDetailRawMother::createWithoutFormat()
            );

        $elementDetail = $this->parser->getElementDetail();

        $this->assertIsString(
            $elementDetail->getElementGenre()
        );
        $this->assertNull(
            $elementDetail->getElementFormat()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImg()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImgName()
        );
        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $elementDetail->getElementPublishedDate()
        );
    }

    public function testWithoutDate(): void
    {
        $this
            ->parser
            ->setContent(
                ElementGeneralDetailRawMother::createWithoutDate()
            );

        $elementDetail = $this->parser->getElementDetail();

        $this->assertIsString(
            $elementDetail->getElementGenre()
        );
        $this->assertIsString(
            $elementDetail->getElementFormat()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImg()
        );
        $this->assertIsString(
            $elementDetail->getElementCoverImgName()
        );
        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $elementDetail->getElementPublishedDate()
        );
    }
}
