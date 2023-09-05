<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PlainTextExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('strip_tags', [$this, 'stripTags']),
        ];
    }

    public function stripTags($value)
    {
        return strip_tags($value);
    }
}