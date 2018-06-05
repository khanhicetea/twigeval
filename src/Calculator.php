<?php
namespace Twigeval;

use Twig_Environment;
use Twig_Loader_Array;

class Calculator {
    private $twig;

    public function __construct(Twig_Environment $twig = null)
    {
        $this->twig = $twig ?: new Twig_Environment(new Twig_Loader_Array());    
    }

    public function calculate(string $expression, array $variables = []) {
        $expression = trim($expression);

        if (substr($expression, 0, 2) != "{{" && substr($expression, -2) != "}}") {
            $expression = '{{ '.$expression.' }}';
        }

        $result = $this->twig->createTemplate($expression)->render($variables);

        return $result;
    }

    public function number(string $expression, array $variables = []) {
        $result = $this->calculate($expression, $variables);

        return is_int($result) ? (int) $result : (double) $result;
    }

    public function isTrue(string $expression, array $variables = []) {
        $expression = $expression." ? 1 : 0";
        $result = $this->calculate($expression, $variables);

        return $result == "1";
    }

    public function isFalse(string $expression, array $variables = []) {
        return !$this->isTrue($expression, $variables);
    }
}