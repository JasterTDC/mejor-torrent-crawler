<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Notification;

/**
 * Class SendNotificationUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Notification
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SendNotificationUseCaseResponse
{

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * SendNotificationUseCaseResponse constructor.
     *
     * @param bool $success
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
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
