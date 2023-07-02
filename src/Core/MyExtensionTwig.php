<?php
namespace App\Core;

use \Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class for my Twig customizations (functions, filters)
 */
class MyExtensionTwig extends AbstractExtension
{


    /**
     * Functions List
     */
    public function getFunctions()
    {
        return[
        new TwigFunction('activeClass', [$this, 'activeClass'], ['needs_context' => true])
        ];
    }


    /**
     * Gives class 'active' to the current page
     */
    public function activeClass(array $context, $page)
    {
        if (isset($context['current_page']) && $context['current_page'] === $page )
        {
            return ' active ';
        }
    }


    /**
     * Filters List
     */
    public function getFilters()
    {
        return[
        new TwigFilter('truncate', [$this, 'truncate'], ['is_safe' => ['html']])
    ];
    }


    public function truncate(string $values, int $nbChar)
    {
        return mb_substr($values, 0, $nbChar,'UTF-8');
    }


}