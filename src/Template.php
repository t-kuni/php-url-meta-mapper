<?php

namespace TKuni\PhpUrlMetaMapper;

class Template
{
    /**
     * @var array
     */
    private $template;

    public function __construct(array $template)
    {
        $this->template = array_map(function($format) {
            return new DataBinder($format);
        }, $template);
    }

    public function bind(array $data) {
        return array_map(function(DataBinder $binder) use ($data) {
            return $binder->bind($data);
        }, $this->template);
    }
}