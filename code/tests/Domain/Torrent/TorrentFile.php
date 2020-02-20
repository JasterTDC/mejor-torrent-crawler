<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Torrent;

/**
 * Class TorrentFile
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TorrentFile
{
    /** @var int */
    protected int $elementGeneralId;

    /** @var string */
    protected string $torrentFilename;

    /**
     * TorrentFile constructor.
     *
     * @param int $elementGeneralId
     * @param string $torrentFilename
     */
    public function __construct(
        int $elementGeneralId,
        string $torrentFilename
    ) {
        $this->elementGeneralId = $elementGeneralId;
        $this->torrentFilename = $torrentFilename;
    }

    /**
     * @return int
     */
    public function getElementGeneralId(): int
    {
        return $this->elementGeneralId;
    }

    /**
     * @return string
     */
    public function getTorrentFilename(): string
    {
        return $this->torrentFilename;
    }
}
