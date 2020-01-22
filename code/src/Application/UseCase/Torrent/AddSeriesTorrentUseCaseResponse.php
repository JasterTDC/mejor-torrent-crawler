<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * AddSeriesTorrentUseCaseResponse
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class AddSeriesTorrentUseCaseResponse
{

    /**
     * It indicates if the action was successful or not
     *
     * @var bool
     */
    protected $success;

    /**
     * Error message
     *
     * @var string|null
     */
    protected $error;

    /**
     * AddSeriesUseCaseResponse constructor
     *
     * @param boolean $success
     * @param string|null $error
     */
    public function __construct(
        bool $success,
        ?string $error
    ) {
        $this->success = $success;
        $this->error = $error;
    }

    /**
     * Get it indicates if the action was successful or not
     *
     * @return  bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Get error message
     *
     * @return  string|null
     */
    public function getError()
    {
        return $this->error;
    }
}
