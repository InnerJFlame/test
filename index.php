<?php

class A
{
    public function __construct($a, $b)
    {
        if ('aa' == $a) {
            echo 11;
        }
        return $a . $b;
    }
}