<?php

namespace Tigmium\PhpUrlMetaMapper;

use Closure;

class Mapper {
    /**
     * @var MappingRule[]
     */
    private $rules = [];

    /**
     * @var MappingRule
     */
    private $currentRule = null;

    public function map($paths) {
        if (!is_array($paths)) {
            $paths = [$paths];
        }

        array_push($this->rules, new MappingRule($paths));
        $this->currentRule = &$this->rules[count($this->rules) - 1];
        return $this;
    }

    public function pre(Closure $hook)
    {
        $this->currentRule->setPreHook($hook);
        return $this;
    }

    /**
     * @param array|Closure $template
     * @return $this
     */
    public function provide($template) {
        $this->currentRule->setTemplate($template);
        return $this;
    }

    public function resolve($url) {
        $urlInfo = parse_url($url);
        $query = [];
        if (!empty($urlInfo['query']))
            parse_str($urlInfo['query'], $query);

        foreach ($this->rules as $rule) {
            if (($resolved = $rule->resolve($urlInfo['path'])) !== null) {
                $route = $resolved->route;
                $binding = [];

                if ($resolved->preHook !== null) {
                    $ret = $resolved->preHook->call($this, $route, $query, $binding);
                    $route = $ret['route'];
                    $query = $ret['query'];
                    $binding = $ret['binding'];
                }

                $tmpl = null;
                if (is_object($resolved->template) && $resolved->template instanceof Closure) {
                    $tmpl = $resolved->template->call($this, $route, $query);
                } else {
                    $tmpl = $resolved->template;
                }
                return (new Template($tmpl))->bind($binding);
            }
        }

        throw new \Exception('Not found matching path.');
    }
}