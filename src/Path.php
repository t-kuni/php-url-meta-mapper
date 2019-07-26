<?php

class Path
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function match($path) {
        return $this->path === $path;
    }
}