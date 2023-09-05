<?php
// src/Twig/SlugifyExtension.php
namespace App\Twig;

use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SlugifyExtension extends AbstractExtension
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('slugify', [$this, 'slugify']),
        ];
    }

    public function slugify($string)
    {
        return $this->slugger->slug($string)->lower()->toString();
    }
}
