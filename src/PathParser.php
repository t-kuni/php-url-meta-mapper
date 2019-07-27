<?php


class PathParser
{
    private $routeParamNames = [];
    private $regexp = null;

    public function parse(string $path) {
        preg_match_all('/[^\\\]{([^}]*)}/', $path, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $routeParamName) {
                array_push($this->routeParamNames, $routeParamName);
            }
        }

        $this->regexp = preg_replace('/([^\\\]){([^}]*)}/', '$1([^/]*)', $path);
        $this->regexp = '|^' . $this->regexp . '$|';

        return $this->regexp;
    }

    public function resolveRouteParams(string $path) {
        preg_match_all($this->regexp, $path, $matches);

        $params = [];

        foreach ($this->routeParamNames as $i => $name) {
            $params[$name] = $matches[1][$i];
        }
    }
}