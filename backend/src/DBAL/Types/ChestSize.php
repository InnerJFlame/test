<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ChestSize extends AbstractEnumType
{
    public const CHEST_XXS = 1;
    public const CHEST_XS  = 2;
    public const CHEST_S   = 3;
    public const CHEST_M   = 4;
    public const CHEST_L   = 5;
    public const CHEST_XL  = 6;

    public static $choices = [
        self::CHEST_XXS => 'XXS',
        self::CHEST_XS  => 'XS',
        self::CHEST_S   => 'S',
        self::CHEST_M   => 'M',
        self::CHEST_L   => 'L',
        self::CHEST_XL  => 'XL',
    ];
}
