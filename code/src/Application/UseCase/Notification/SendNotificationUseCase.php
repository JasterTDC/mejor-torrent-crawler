<?php


namespace BestThor\ScrappingMaster\Application\UseCase\Notification;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Notification\NotificationServiceInterface;

/**
 * Class SendNotificationUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Notification
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SendNotificationUseCase
{
    // Channel identifier
    const CHANNEL_ID = 3277573;

    /**
     * @var NotificationServiceInterface
     */
    protected $notificationService;

    /**
     * @var ElementGeneralReaderRepositoryInterface
     */
    protected $elementGeneralReaderRepository;

    /**
     * SendNotificationUseCase constructor.
     *
     * @param NotificationServiceInterface $notificationService
     * @param ElementGeneralReaderRepositoryInterface $elementGeneralReaderRepository
     */
    public function __construct(
        NotificationServiceInterface $notificationService,
        ElementGeneralReaderRepositoryInterface $elementGeneralReaderRepository
    ) {
        $this->notificationService = $notificationService;
        $this->elementGeneralReaderRepository = $elementGeneralReaderRepository;
    }

    /**
     * @return SendNotificationUseCaseResponse
     */
    public function handle() : SendNotificationUseCaseResponse
    {
        $total = $this
            ->elementGeneralReaderRepository
            ->getTotal();

        $generalCollection = $this
            ->elementGeneralReaderRepository
            ->getElementGeneralByPage(1, 5);

        $this
            ->notificationService
            ->sendMessage([
                'chat_id'       => self::CHANNEL_ID,
                'text'          => "We have *{$total}* films crawled !",
                'parse_mode'    => 'Markdown'
            ]);

        /** @var ElementGeneral $elementGeneral */
        foreach ($generalCollection as $elementGeneral) {
            $elementMessage = "*{$elementGeneral->getElementName()}*\n";

            $elementMessage .= $elementGeneral->getElementDetail()->getElementFormat() . "\n";
            $elementMessage .= $elementGeneral->getElementDetail()->getElementDescription();

            $message = $this
                ->notificationService
                ->sendMessage([
                    'chat_id'       => self::CHANNEL_ID,
                    'text'          => "{$elementMessage}",
                    'parse_mode'    => 'Markdown'
                ]);

            if (!empty($message['ok'])) {
                $this
                    ->notificationService
                    ->sendPhoto([
                        'chat_id'   => self::CHANNEL_ID,
                        'photo'     => "http://korean-tomato.duckdns.org/static/img/{$elementGeneral->getElementId()}.jpg",
                        'reply_to_message_id' => $message['result']['message_id']
                    ]);
            }
        }

        return new SendNotificationUseCaseResponse(
            true,
            null
        );
    }
}
