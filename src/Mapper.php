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

    public function provide(array $template) {
        $this->currentRule->setTemplate($template);
        return $this;
    }

    public function resolve($url) {
        $urlInfo = parse_url($url);

        foreach ($this->rules as $rule) {
            if (($template = $rule->resolve($urlInfo['path'])) !== null) {
                return $template;
            }
        }

        throw new \Exception('Not found matching path.');
    }
}