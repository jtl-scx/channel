<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 10/2/19
 */

namespace JTL\SCX\Channel\Model;

use JTL\SCX\Lib\Channel\Persistence\PgSql\Contract\IPgModel;

class Offer implements IPgModel
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int
     */
    private $offerId;

    /**
     * @var string
     */
    private $sellerId;

    /**
     * @var \DateTimeImmutable|null
     */
    private $endedAt;

    public function __construct(?int $id, int $offerId, string $sellerId, ?\DateTimeImmutable $endedAt)
    {
        $this->id = $id;
        $this->offerId = $offerId;
        $this->sellerId = $sellerId;
        $this->endedAt = $endedAt;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOfferId(): int
    {
        return $this->offerId;
    }

    /**
     * @return string
     */
    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'offerid' => $this->getOfferId(),
            'sellerid' => $this->getSellerId(),
            'endedat' => $this->getEndedAt()->format('c')
        ];
    }
}
