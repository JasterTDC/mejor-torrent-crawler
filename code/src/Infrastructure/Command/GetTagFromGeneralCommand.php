<?php


namespace BestThor\ScrappingMaster\Infrastructure\Command;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetTagFromGeneralUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetTagFromGeneralCrawlerCommand
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Command
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagFromGeneralCommand extends Command
{

    /**
     * @var GetTagFromGeneralUseCase
     */
    protected $useCase;

    /**
     * GetTagFromGeneralCrawlerCommand constructor.
     *
     * @param GetTagFromGeneralUseCase $useCase
     */
    public function __construct(
        GetTagFromGeneralUseCase $useCase
    ) {
        $this->useCase = $useCase;

        parent::__construct();
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this
            ->setName('tag:general')
            ->setDescription('Get tag from general')
            ->setHelp('Get tag from general');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    public function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $response = $this
            ->useCase
            ->handle();
    }
}
