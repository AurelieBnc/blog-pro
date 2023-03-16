<?php
namespace App\Core;

use \Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class for my Twig customizations (functions, filters)
 */
class MyExtensionTwig extends AbstractExtension
{
    /**
     * Function List
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
}