<?php

class Path
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $regexp;


    public function __construct(string $path)
    {
        $this->path   = $path;
        $this->regexp = (new PathParser())->parse($path);
    }

    public function match($path)
    {
        return preg_match($this->regexp, $path);
    }
}