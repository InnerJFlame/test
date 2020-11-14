<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class UserRole extends AbstractEnumType
{
    public const ROLE_CLIENT = 'ROLE_CLIENT';
    public const ROLE_ESCORT = 'ROLE_ESCORT';
    public const ROLE_ADMIN  = 'ROLE_ADMIN';

    protected static $choices = [
        self::ROLE_CLIENT => 'Client',
        self::ROLE_ESCORT => 'Escort',
        self::ROLE_ADMIN  => 'Admin',
    ];
}
