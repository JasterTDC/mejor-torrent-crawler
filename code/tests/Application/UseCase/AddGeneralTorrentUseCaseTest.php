<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Domain\Torrent\TorrentBodyMother;
use BestThor\ScrappingMaster\Tests\Domain\Torrent\TorrentFileMother;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class AddGeneralTorrentUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class AddGeneralTorrentUseCaseTest extends TestCase
{

    /** @var AddGeneralTorrentUseCase */
    protected $addGeneralTorrentUseCase;

    /** @var TransmissionClient */
    protected $torrentClient;

    public function testIfAddTorrentIsOkThenReturnsValidResponse(): void
    {
        $torrentFile = TorrentFileMother::random();

        $mock = new MockHandler([
            new Response(200, [], TorrentBodyMother::random())
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $this->torrentClient = new TransmissionClient(
            MotherCreator::random()->domainWord,
            MotherCreator::random()->numberBetween(1, 10000),
            MotherCreator::random()->userName,
            MotherCreator::random()->password,
            $client
        );

        $this->addGeneralTorrentUseCase = new AddGeneralTorrentUseCase(
            $this->torrentClient,
            '/tmp/'
        );

        $response = $this
            ->addGeneralTorrentUseCase
            ->handle(
                new AddGeneralTorrentUseCaseArguments(
                    $torrentFile->getElementGeneralId()
                )
            );

        $this->assertTrue($response->isSuccess());

        unlink($torrentFile->getTorrentFilename());
    }

    public function testIfAddTorrentIsNotOkThenReturnsValidResponse(): void
    {
        $torrentFile = TorrentFileMother::random();

        $mock = new MockHandler([
            new Response(200, [], TorrentBodyMother::random())
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $this->torrentClient = new TransmissionClient(
            MotherCreator::random()->domainWord,
            MotherCreator::random()->numberBetween(1, 10000),
            MotherCreator::random()->userName,
            MotherCreator::random()->password,
            $client
        );

        $this->addGeneralTorrentUseCase = new AddGeneralTorrentUseCase(
            $this->torrentClient,
            '/tmp/'
        );

        $response = $this
            ->addGeneralTorrentUseCase
            ->handle(
                new AddGeneralTorrentUseCaseArguments(
                    $torrentFile->getElementGeneralId() + 1
                )
            );

        $this->assertFalse($response->isSuccess());

        unlink($torrentFile->getTorrentFilename());
    }

    public function testIfAddTorrentThrowsExceptionReturnsValidResponse(): void
    {
        $torrentFile = TorrentFileMother::random();

        $mock = new MockHandler([
            new ClientException(
                'Client exception',
                new Request(
                    'POST',
                    '/torrent/add'
                ),
                new Response(
                    409,
                    [
                        'X-Transmission-Session-Id' => MotherCreator::random()->sha256
                    ]
                )
            ),
            new Response(200, [], TorrentBodyMother::random())
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $this->torrentClient = new TransmissionClient(
            MotherCreator::random()->domainWord,
            MotherCreator::random()->numberBetween(1, 10000),
            MotherCreator::random()->userName,
            MotherCreator::random()->password,
            $client
        );

        $this->addGeneralTorrentUseCase = new AddGeneralTorrentUseCase(
            $this->torrentClient,
            '/tmp/'
        );

        $response = $this
            ->addGeneralTorrentUseCase
            ->handle(
                new AddGeneralTorrentUseCaseArguments(
                    $torrentFile->getElementGeneralId()
                )
            );

        $this->assertTrue($response->isSuccess());

        unlink($torrentFile->getTorrentFilename());
    }

    public function testIfAddTorrentThrowsExceptionAndTokenIsNotValidReturnsValidResponse(): void
    {
        $torrentFile = TorrentFileMother::random();

        $mock = new MockHandler([
            new ClientException(
                'Client exception',
                new Request(
                    'POST',
                    '/torrent/add'
                ),
                new Response(
                    401
                )
            ),
            new Response(200, [], TorrentBodyMother::random())
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $this->torrentClient = new TransmissionClient(
            MotherCreator::random()->domainWord,
            MotherCreator::random()->numberBetween(1, 10000),
            MotherCreator::random()->userName,
            MotherCreator::random()->password,
            $client
        );

        $this->addGeneralTorrentUseCase = new AddGeneralTorrentUseCase(
            $this->torrentClient,
            '/tmp/'
        );

        $response = $this
            ->addGeneralTorrentUseCase
            ->handle(
                new AddGeneralTorrentUseCaseArguments(
                    $torrentFile->getElementGeneralId()
                )
            );

        $this->assertTrue($response->isSuccess());

        unlink($torrentFile->getTorrentFilename());
    }
}
