<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class UserStatus extends AbstractEnumType
{
    public const STATUS_WAITING   = 0;
    public const STATUS_CONFIRMED = 1;

    protected static $choices = [
        self::STATUS_WAITING   => 'Waiting',
        self::STATUS_CONFIRMED => 'Confirmed',
    ];
}
