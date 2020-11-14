<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class HairColor extends AbstractEnumType
{
    public const HAIR_BLACK  = 1;
    public const HAIR_BROWN  = 2;
    public const HAIR_BLONDE = 3;
    public const HAIR_RED    = 4;

    public static $choices = [
        self::HAIR_BLACK  => 'Black',
        self::HAIR_BROWN  => 'Brown',
        self::HAIR_BLONDE => 'Blonde',
        self::HAIR_RED    => 'Red',
    ];
}
