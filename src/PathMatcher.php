<?php

namespace TKuni\PhpUrlMetaMapper;

class PathMatcher
{
    private $routeParamNames = [];
    private $regexp = null;

    public function __construct(string $pathPattern)
    {
        $this->regexp = $this->parse($pathPattern);
    }

    private function parse(string $pathPattern) {
        preg_match_all('/[^\\\]{([^}]*)}/', $pathPattern, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $routeParamName) {
                array_push($this->routeParamNames, $routeParamName);
            }
        }

        $regexp = preg_replace('/([^\\\]){([^}]*)}/', '$1([^/]*)', $pathPattern);
        $regexp = '|^' . $regexp . '$|';

        return $regexp;
    }

    public function match(string $path) {
        preg_match($this->regexp, $path, $matches);

        if (!$matches) {
            return null;
        }

        $routeParams = [];

        foreach ($this->routeParamNames as $i => $name) {
            $routeParams[$name] = $matches[$i + 1];
        }

        return $routeParams;
    }
}