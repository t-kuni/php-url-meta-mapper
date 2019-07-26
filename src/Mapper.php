<?php

namespace MetaMapper;

class Mapper {
    private $rules = [];
    private $currentRule = null;

    public function map($paths) {
        array_push($this->rules, [
            'paths' => $paths,
            'template' => null,
        ]);
        $this->currentRule = &$this->rules[count($this->rules) - 1];
        return $this;
    }

    public function provide($template) {
        $this->currentRule['template'] = $template;
        return $this;
    }

    public function resolve($url) {
        $urlInfo = parse_url($url);

        foreach ($this->rules as $rule) {
            foreach ($rule['paths'] as $path) {
                if ($urlInfo['path'] === $path) {
                    return $rule['template'];
                }
            }
        }

        throw new \Exception('Not found matching path.');
    }
}