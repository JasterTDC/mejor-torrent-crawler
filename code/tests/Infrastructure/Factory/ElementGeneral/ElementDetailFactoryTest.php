<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementGeneral;

use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDetailFactory;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementDetailRawMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementDetailFactoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailFactoryTest extends TestCase
{
    public const TESTING_IMAGES = '/tmp/testing_images/';

    /** @var ElementDetailFactory */
    protected $elementDetailFactory;

    protected function setUp(): void
    {
        $this->elementDetailFactory = new ElementDetailFactory();
    }

    protected function tearDown(): void
    {
        $this->elementDetailFactory = null;
    }

    public function testIfParametersAreValidThenObjectIsCreated()
    {
        $rawElementDetail = ElementDetailRawMother::random();

        $elementDetail = $this
            ->elementDetailFactory
            ->createElementDetailFromRaw(
                $rawElementDetail
            );

        $this->assertEquals(
            $elementDetail->getElementGenre(),
            $rawElementDetail[ElementDetailRawMother::GENRE_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementFormat(),
            $rawElementDetail[ElementDetailRawMother::FORMAT_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementDescription(),
            $rawElementDetail[ElementDetailRawMother::DESCRIPTION_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementCoverImg(),
            $rawElementDetail[ElementDetailRawMother::COVER_IMG_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementCoverImgName(),
            $rawElementDetail[ElementDetailRawMother::COVER_IMG_NAME_ATTR]
        );
    }

    public function testIfParametersAreValidWithPublishedDateThenObjectIsCreated()
    {
        $rawElementDetail = ElementDetailRawMother::create();

        $elementDetail = $this
            ->elementDetailFactory
            ->createElementDetailFromRaw(
                $rawElementDetail
            );

        $this->assertEquals(
            $elementDetail->getElementGenre(),
            $rawElementDetail[ElementDetailRawMother::GENRE_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementFormat(),
            $rawElementDetail[ElementDetailRawMother::FORMAT_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementDescription(),
            $rawElementDetail[ElementDetailRawMother::DESCRIPTION_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementCoverImg(),
            $rawElementDetail[ElementDetailRawMother::COVER_IMG_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementCoverImgName(),
            $rawElementDetail[ElementDetailRawMother::COVER_IMG_NAME_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementPublishedDate()->format('Y-m-d'),
            $rawElementDetail[ElementDetailRawMother::PUBLISHED_DATE_ATTR]
        );
    }

    public function testIfImageIsEmptyThenObjectIsCreated()
    {
        $rawElementDetail = ElementDetailRawMother::missingImage();

        $elementDetail = $this
            ->elementDetailFactory
            ->createElementDetailFromRaw(
                $rawElementDetail
            );

        $this->assertEquals(
            $elementDetail->getElementGenre(),
            $rawElementDetail[ElementDetailRawMother::GENRE_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementFormat(),
            $rawElementDetail[ElementDetailRawMother::FORMAT_ATTR]
        );
        $this->assertEquals(
            $elementDetail->getElementDescription(),
            $rawElementDetail[ElementDetailRawMother::DESCRIPTION_ATTR]
        );
        $this->assertNull(
            $elementDetail->getElementCoverImg()
        );
        $this->assertNull(
            $elementDetail->getElementCoverImgName()
        );
    }
}
