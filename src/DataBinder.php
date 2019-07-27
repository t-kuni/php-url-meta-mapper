<?php

namespace Tigmium\PhpUrlMetaMapper;

class DataBinder
{
    /**
     * @var string
     */
    private $format;

    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function bind(array $data) {
        $str = $this->format;
        foreach ($data as $key => $val) {
            $str = preg_replace('|\{\{' . $key . '\}\}|', $val, $str);
        }
        return $str;
    }
}