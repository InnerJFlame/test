<?php

class A
{
    public function __construct($a, $b)
    {

        if ('aa' == $a)
        {
            echo 11;
        }

        echo $a . $b;
    }
}
