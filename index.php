<?php

declare(strict_types=1);

namespace App;

class A
{
    public function __construct($a, $b)
    {
        if ('aa' === $a) {
            echo 11;
        }
        $c = 'dd';

        return $a . $b;
    }
}
