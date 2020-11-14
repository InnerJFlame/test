<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class WeekDays extends AbstractEnumType
{
    public const DAY_MONDAY    = 1;
    public const DAY_TUESDAY   = 2;
    public const DAY_WEDNESDAY = 3;
    public const DAY_THURSDAY  = 4;
    public const DAY_FRIDAY    = 5;
    public const DAY_SATURDAY  = 6;
    public const DAY_SUNDAY    = 7;

    public static $choices = [
        self::DAY_MONDAY    => 'Monday',
        self::DAY_TUESDAY   => 'Tuesday',
        self::DAY_WEDNESDAY => 'Wednesday',
        self::DAY_THURSDAY  => 'Thursday',
        self::DAY_FRIDAY    => 'Friday',
        self::DAY_SATURDAY  => 'Saturday',
        self::DAY_SUNDAY    => 'Sunday',
    ];
}
