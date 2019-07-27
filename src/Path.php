<?php

class Path
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var PathMatcher
     */
    private $matcher;


    public function __construct(string $pathPattern)
    {
        $this->path   = $pathPattern;
        $this->matcher = new PathMatcher($pathPattern);
    }

    public function match($path)
    {
        return $this->matcher->match($path);
    }
}