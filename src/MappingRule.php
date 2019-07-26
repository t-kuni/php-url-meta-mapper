<?php
class MappingRule
{
    /**
     * @var Path[]
     */
    private $paths;
    /**
     * @var array
     */
    private $template;

    public function __construct(array $paths)
    {
        $this->paths = array_map(function($path) {
            return new Path($path);
        }, $paths);
        $this->template = null;
    }

    public function setTemplate(array $template) {
        $this->template = $template;
    }

    public function resolve(string $path) {
        foreach ($this->paths as $rulePath) {
            if ($rulePath->match($path))
                return $this->template;
        }

        return null;
    }
}