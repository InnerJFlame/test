<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LanguageExtensions extends AbstractExtension
{
    static private $locales = [
        'en' => 'English',
        'ro' => 'Romania',
    ];

    public function getFunctions()
    {
        return [
            new TwigFunction('language_name', [$this, 'getLanguageName']),
        ];
    }

    public function getLanguageName(string $locale)
    {
        return self::$locales[substr($locale, 0, 2)] ?? 'Unknown';
    }
}
