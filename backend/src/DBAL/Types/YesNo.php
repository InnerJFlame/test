<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class YesNo extends AbstractEnumType
{
    public const NO  = 0;
    public const YES = 1;

    public static $choices = [
        self::NO  => 'No',
        self::YES => 'Yes',
    ];
}
