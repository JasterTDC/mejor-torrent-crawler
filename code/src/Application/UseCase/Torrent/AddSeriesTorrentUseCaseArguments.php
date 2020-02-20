<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * AddSeriesTorrentUseCaseArguments
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class AddSeriesTorrentUseCaseArguments
{

    /**
     * ElementSeries name
     *
     * @var string
     */
    protected string $seriesName;

    /**
     * AddSeriesTorrentUseCaseArguments constructor
     *
     * @param string $seriesName
     */
    public function __construct(
        string $seriesName
    ) {
        $this->seriesName = $seriesName;
    }

    /**
     * Get elementSeries name
     *
     * @return  string
     */
    public function getSeriesName(): string
    {
        return $this->seriesName;
    }
}
