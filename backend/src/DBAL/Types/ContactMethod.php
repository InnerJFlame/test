<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ContactMethod extends AbstractEnumType
{

    public const CONTACT_PHONE_CALL = 1;
    public const CONTACT_SMS        = 2;
    public const CONTACT_WHATSAPP   = 3;

    public static $choices = [
        self::CONTACT_PHONE_CALL => 'Phone Call',
        self::CONTACT_SMS        => 'SMS',
        self::CONTACT_WHATSAPP   => 'Whatsapp',
    ];

}
