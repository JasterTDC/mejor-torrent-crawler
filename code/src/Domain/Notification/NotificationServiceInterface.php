<?php


namespace BestThor\ScrappingMaster\Domain\Notification;

/**
 * Interface NotificationServiceInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Notification
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface NotificationServiceInterface
{
    /**
     * Get bot information
     *
     * @return  array
     */
    public function getMe() : array;

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function sendMessage(array $parameters) : array;

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function sendPhoto(array $parameters) : array;
}
