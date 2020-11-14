<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ContactMessageType extends AbstractEnumType
{
    public const TYPE_INBOX  = 1;
    public const TYPE_OUTBOX = 2;

    public static $choices = [
        self::TYPE_INBOX  => 'Inbox',
        self::TYPE_OUTBOX => 'Outbox',
    ];
}
