<?php


class Resolved
{
    /**
     * @var Closure|string
     */
    public $template;
    /**
     * @var array
     */
    public $route;

    /**
     * Resolved constructor.
     * @param string|Closure $template
     * @param array $route
     */
    public function __construct($template, array $route)
    {
        $this->template = $template;
        $this->route = $route;
    }
}