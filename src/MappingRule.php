<?php
class MappingRule
{
    /**
     * @var Path[]
     */
    private $paths;
    /**
     * @var array|Closure
     */
    private $template = null;
    /**
     * @var Closure
     */
    private $preHook = null;

    public function __construct(array $paths)
    {
        $this->paths = array_map(function($path) {
            return new Path($path);
        }, $paths);
    }

    /**
     * @param array|Closure $template
     */
    public function setTemplate($template) {
        $this->template = $template;
    }

    public function setPreHook(Closure $hook) {
        $this->preHook = $hook;
    }

    public function resolve(string $path) {
        foreach ($this->paths as $rulePath) {
            if (($route = $rulePath->match($path)) !== null) {
                return new Resolved($this->template, $route, $this->preHook);
            }
        }

        return null;
    }
}