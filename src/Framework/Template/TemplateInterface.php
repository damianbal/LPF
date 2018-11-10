<?php

namespace LPF\Framework\Template;

interface TemplateInterface
{
    /**
     * Return rendered body
     *
     * @param string $name
     * @param array $data 
     * @return string
     */
    public function render($name, $data = []) : string;
}
