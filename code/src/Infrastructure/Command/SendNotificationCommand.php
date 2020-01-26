<?php


namespace BestThor\ScrappingMaster\Infrastructure\Command;

use BestThor\ScrappingMaster\Application\UseCase\Notification\SendNotificationUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SendNotificationCommand
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Command
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SendNotificationCommand extends Command
{

    /**
     * @var SendNotificationUseCase
     */
    protected $useCase;

    /**
     * SendNotificationCommand constructor.
     *
     * @param SendNotificationUseCase $useCase
     */
    public function __construct(
        SendNotificationUseCase $useCase
    ) {
        $this->useCase = $useCase;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('notification:send')
            ->setDescription('Send general notification')
            ->setHelp('Send general notification');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->useCase->handle();
    }
}
