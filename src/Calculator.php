<?php
namespace KhanhIceTea\Twigeval;

use Twig_Environment;
use Twig_Loader_Array;
use Exception;

class Calculator
{
    private $twig;
    private $cacthException;

    // Be carefully !!! eval function will be runned if $cacheDir equals false
    public function __construct($cacheDir = null, $cacthException = true, array $twigOptions = [])
    {
        $this->cacthException = $cacthException;

        $twigOptions = array_merge(array(
            'strict_variables' => true,
            'cache' => is_null($cacheDir) ? sys_get_temp_dir() : $cacheDir,
        ), $twigOptions);

        $this->twig = new Twig_Environment(new Twig_Loader_Array(), $twigOptions);
    }

    public function renderFromString(string $template, array $variables = [])
    {
        // md5 is enough for hashing key cache and performance
        $name = '__string_template__'.md5($template);
        $this->twig->getLoader()->setTemplate($name, $template);

        try {
            return $this->twig->loadTemplate($name)->render($variables);
        } catch (Exception $e) {
            if ($this->cacthException) {
                return null;
            }
            throw $e;
        }
    }

    public function calculate(string $expression, array $variables = [])
    {
        $expression = trim($expression);

        if (substr($expression, 0, 2) != "{{" && substr($expression, -2) != "}}") {
            $expression = '{{ '.$expression.' }}';
        }

        return $this->renderFromString($expression, $variables);
    }

    public function number(string $expression, array $variables = [])
    {
        $result = $this->calculate($expression, $variables);

        return is_null($result) ? null : (is_int($result) ? (int) $result : (double) $result);
    }

    public function isTrue(string $expression, array $variables = [])
    {
        $expression = $expression." ? 1 : 0";
        $result = $this->calculate($expression, $variables);

        return is_null($result) ? null : ($result === "1");
    }

    public function isFalse(string $expression, array $variables = [])
    {
        $isTrue = $this->isTrue($expression, $variables);

        return is_null($isTrue) ? null : !$isTrue;
    }
}
