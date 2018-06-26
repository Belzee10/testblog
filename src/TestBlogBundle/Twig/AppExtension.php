<?php

namespace TestBlogBundle\Twig;

class AppExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('truncate', array($this, 'truncateFilter')),
        );
    }

    public function truncateFilter($text, $length)
    {
        $string = substr($text, 0, $length);

        return $string.'...';
    }

    public function getName()
    {
        return 'app_extension';
    }
}