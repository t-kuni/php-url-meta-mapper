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
     * @var null|Closure
     */
    public $preHook;

    /**
     * Resolved constructor.
     * @param string|Closure $template
     * @param array $route
     * @param null|Closure $preHook
     */
    public function __construct($template, array $route, $preHook)
    {
        $this->template = $template;
        $this->route = $route;
        $this->preHook = $preHook;
    }
}