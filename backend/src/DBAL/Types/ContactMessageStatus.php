<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ContactMessageStatus extends AbstractEnumType
{
    public const STATUS_UNREAD = 1;
    public const STATUS_OPEN   = 2;
    public const STATUS_SOLVED = 3;
    public const STATUS_CLOSED = 4;

    public static $choices = [
        self::STATUS_UNREAD => 'Unread',
        self::STATUS_OPEN   => 'Open',
        self::STATUS_SOLVED => 'Solved',
        self::STATUS_CLOSED => 'Closed',
    ];
}
