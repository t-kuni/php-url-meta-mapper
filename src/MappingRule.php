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
    private $template;

    public function __construct(array $paths)
    {
        $this->paths = array_map(function($path) {
            return new Path($path);
        }, $paths);
        $this->template = null;
    }

    /**
     * @param array|Closure $template
     */
    public function setTemplate($template) {
        $this->template = $template;
    }

    public function resolve(string $path) {
        foreach ($this->paths as $rulePath) {
            if (($route = $rulePath->match($path)) !== null) {
                return new Resolved($this->template, $route);
            }
        }

        return null;
    }
}