<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"={"method"="GET", "controller"=NotFoundAction::class, "read"=false, "output"=false}}
 * )
 */
class ContactMessageStats
{
    public $date;

    public $total;

    public $unread;

    public $open;

    public $solved;

    /**
     * ContactMessageStats constructor.
     *
     * @param DateTimeInterface $date
     * @param int               $total
     * @param int               $unread
     * @param int               $open
     * @param int               $solved
     */
    public function __construct(DateTimeInterface $date, int $total, int $unread, int $open, int $solved)
    {
        $this->date = $date;
        $this->total = $total;
        $this->unread = $unread;
        $this->open = $open;
        $this->solved = $solved;
    }

    /**
     * @ApiProperty(identifier=true)
     */
    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
    }
}
