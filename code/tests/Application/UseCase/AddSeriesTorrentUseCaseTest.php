<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Domain\Torrent\TorrentBodyMother;
use BestThor\ScrappingMaster\Tests\Domain\Torrent\TorrentFileMother;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class AddSeriesTorrentUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class AddSeriesTorrentUseCaseTest extends TestCase
{
    /** @var AddSeriesTorrentUseCase */
    protected AddSeriesTorrentUseCase $addSeriesTorrentUseCase;

    /** @var TransmissionClient */
    protected TransmissionClient $transmissionClient;

    public function testIfAddSeriesIsValidThenReturnsValidResponse(): void
    {
        $word = MotherCreator::random()->word;
        $directory = "/tmp/{$word}/";

        mkdir($directory);

        TorrentFileMother::random($directory);

        $mock = new MockHandler([
            new Response(200, [], TorrentBodyMother::random())
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $this->transmissionClient = new TransmissionClient(
            MotherCreator::random()->domainWord,
            MotherCreator::random()->numberBetween(1, 10000),
            MotherCreator::random()->userName,
            MotherCreator::random()->password,
            $client
        );

        $this->addSeriesTorrentUseCase = new AddSeriesTorrentUseCase(
            '/tmp/',
            $this->transmissionClient
        );

        $response = $this
            ->addSeriesTorrentUseCase
            ->handle(
                new AddSeriesTorrentUseCaseArguments(
                    $word
                )
            );

        $this->assertTrue($response->getSuccess());
        $this->assertNull($response->getError());

        /** @var \DirectoryIterator $file */
        foreach (new \DirectoryIterator($directory) as $file) {
            if (!$file->isDot()) {
                unlink($file->getPathname());
            }
        }
        rmdir($directory);
    }

    public function testIfStaticDirectoryDoesNotExistAndReturnsValidResponse(): void
    {
        $word = MotherCreator::random()->word;

        $mock = new MockHandler([
            new Response(200, [], TorrentBodyMother::random())
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $this->transmissionClient = new TransmissionClient(
            MotherCreator::random()->domainWord,
            MotherCreator::random()->numberBetween(1, 10000),
            MotherCreator::random()->userName,
            MotherCreator::random()->password,
            $client
        );

        $this->addSeriesTorrentUseCase = new AddSeriesTorrentUseCase(
            '/tmp/',
            $this->transmissionClient
        );

        $response = $this
            ->addSeriesTorrentUseCase
            ->handle(
                new AddSeriesTorrentUseCaseArguments(
                    $word
                )
            );

        $this->assertFalse($response->getSuccess());
        $this->assertIsString($response->getError());
        $this->assertNotEmpty($response->getError());
    }
}
