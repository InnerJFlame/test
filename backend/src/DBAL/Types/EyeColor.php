<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class EyeColor extends AbstractEnumType
{
    public const EYE_BROWN = 1;
    public const EYE_HAZEL = 2;
    public const EYE_BLUE  = 3;
    public const EYE_GREEN = 4;
    public const EYE_GRAY  = 5;
    public const EYE_AMBER = 6;

    public static $choices = [
        self::EYE_BROWN => 'Brown',
        self::EYE_HAZEL => 'Hazel',
        self::EYE_BLUE  => 'Blue',
        self::EYE_GREEN => 'Green',
        self::EYE_GRAY  => 'Gray',
        self::EYE_AMBER => 'Amber',
    ];
}
