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
     * ElementSeries identifier
     *
     * @var int
     */
    protected $seriesId;

    /**
     * ElementSeries name
     *
     * @var string
     */
    protected $seriesName;

    /**
     * AddSeriesTorrentUseCaseArguments constructor
     *
     * @param int $seriesId
     * @param string $seriesName
     */
    public function __construct(
        int $seriesId,
        string $seriesName
    ) {
        $this->seriesId = $seriesId;
        $this->seriesName = $seriesName;
    }

    /**
     * Get elementSeries identifier
     *
     * @return  int
     */
    public function getSeriesId()
    {
        return $this->seriesId;
    }

    /**
     * Get elementSeries name
     *
     * @return  string
     */
    public function getSeriesName()
    {
        return $this->seriesName;
    }
}
