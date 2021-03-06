<?php

namespace BestThor\ScrappingMaster\Infrastructure\Command;

use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCaseResponse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SeriesCrawler
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Command
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SeriesCrawlerCommand extends Command
{

    /**
     * @var GetElementSeriesCollectionUseCase
     */
    protected $useCase;

    /**
     * SeriesCrawler constructor.
     *
     * @param GetElementSeriesCollectionUseCase $useCase
     */
    public function __construct(
        GetElementSeriesCollectionUseCase $useCase
    ) {
        $this->useCase = $useCase;

        parent::__construct();
    }

    /**
     * Configure
     */
    protected function configure(): void
    {
        $this
            ->setName('crawl:series')
            ->addArgument('page', InputArgument::REQUIRED, 'Page number')
            ->setDescription('Crawl series by page')
            ->setHelp('Crawl series page and store info');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $useCase = $this->useCase;

        $page = $input->getArgument('page');

        if (is_null($page) || is_array($page)) {
            $page = 1;
        }

        if (is_string($page)) {
            $page = (int) $page;
        }

        /** @var GetElementSeriesCollectionUseCaseResponse $response */
        $response = $useCase(
            new GetElementSeriesCollectionUseCaseArguments(
                $page
            )
        );

        if (!empty($response->getErrorFile())) {
            foreach ($response->getErrorFile() as $errorFile) {
                $output->writeln($errorFile);
            }
        }

        if (!empty($response->getErrorImage())) {
            foreach ($response->getErrorImage() as $errorImage) {
                $output->writeln($errorImage);
            }
        }

        return 0;
    }
}
