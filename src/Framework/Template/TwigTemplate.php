<?php

namespace LPF\Framework\Template;

/**
 * Twig Template Driver for TemplateInterface
 */
class TwigTemplate implements TemplateInterface
{
    protected $twig = null;

    public function __construct($config)
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../App/Views');
        $this->twig = new \Twig_Environment($loader, []);
    }

    /**
     * Return rendered body
     *
     * @param string $name
     * @param array $data
     * @return string
     */
    public function render($name, $data = []): string
    {
        return $this->twig->render($name, $data);
    }
}
