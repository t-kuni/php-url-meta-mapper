<?php

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
        array_push($this->rules, new MappingRule($paths));
        $this->currentRule = &$this->rules[count($this->rules) - 1];
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
                if (is_object($resolved->template) && $resolved->template instanceof Closure) {
                    return $resolved->template->call($this, $resolved->route, $query);
                } else {
                    return $resolved->template;
                }
            }
        }

        throw new \Exception('Not found matching path.');
    }
}