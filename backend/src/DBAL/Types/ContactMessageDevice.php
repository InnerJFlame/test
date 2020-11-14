<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ContactMessageDevice extends AbstractEnumType
{
    public const TYPE_DESKTOP = 1;
    public const TYPE_TABLET  = 2;
    public const TYPE_MOBILE  = 3;

    public static $choices = [
        self::TYPE_DESKTOP => 'Desktop',
        self::TYPE_TABLET  => 'Tablet',
        self::TYPE_MOBILE  => 'Mobile',
    ];
}
