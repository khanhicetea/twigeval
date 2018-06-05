<?php
namespace Twigeval;

use Twig_Environment;

class Calculator {
    private $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig ?: new Twig_Environment();    
    }

    public function calculate(string $expression, array $variables = []) {
        // TODO
    }
}