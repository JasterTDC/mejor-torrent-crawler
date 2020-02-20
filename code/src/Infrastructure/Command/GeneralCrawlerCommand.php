<?php

namespace BestThor\ScrappingMaster\Infrastructure\Command;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GeneralCrawlerCommand
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Command
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralCrawlerCommand extends Command
{

    /**
     * @var GetElementGeneralCollectionUseCase
     */
    protected $useCase;

    /**
     * GeneralCrawlerCommand constructor.
     *
     * @param GetElementGeneralCollectionUseCase $useCase
     */
    public function __construct(
        GetElementGeneralCollectionUseCase $useCase
    ) {
        $this->useCase = $useCase;

        parent::__construct();
    }

    /**
     * General configure
     */
    protected function configure(): void
    {
        $this
            ->setName('crawl:general')
            ->addArgument('totalPages', InputArgument::REQUIRED, 'Total pages')
            ->setDescription('Crawl films by page')
            ->setHelp('Crawl films and store info');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $totalPages = $input->getArgument('totalPages');

        if (is_array($totalPages) || is_null($totalPages)) {
            $totalPages = 1;
        }

        if (is_string($totalPages)) {
            $totalPages = (int) $totalPages;
        }

        try {
            $response = $this->useCase->handle(
                new GetElementGeneralCollectionArguments(
                    $totalPages
                )
            );

            if (!empty($response->getError())) {
                $output->writeln($response->getError());
            }
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
    }
}
