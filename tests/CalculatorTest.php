<?php

use PHPUnit\Framework\TestCase;
use Twigeval\Calculator;

class CalculatorTest extends TestCase {
    private $calculator;

    public function setUp() {
        $this->calculator = new Calculator();
    }
    
    public function testMath() {
        $exp = "{{ (14 + 7 * 8) ** (49 / 7 - 5)  }}";
        $result = $this->calculator->calculate($exp);

        $this->assertEquals($result, "4900");
    }

    public function testMathWithoutBrackets() {
        $exp = "(12 + 58) * (49 / 7 - 5)";
        $result = $this->calculator->calculate($exp);

        $this->assertEquals($result, "140");
    }

    public function testMathVariables() {
        $exp = "{{ a * 3 + b / 5 }}";
        $result = $this->calculator->calculate($exp, ['a' => 9, 'b' => 40]);

        $this->assertEquals($result, "35");
    }

    public function testMathVariablesWithoutBrackets() {
        $exp = "a * 3 + b / 5";
        $result = $this->calculator->calculate($exp, ['a' => 9, 'b' => 40]);

        $this->assertEquals($result, "35");
    }

    public function testStringVariables() {
        $exp = "{{ name|reverse }}@{{ domain|upper }}";
        $result = $this->calculator->calculate($exp, ['name' => 'hello', 'domain' => 'google.com']);

        $this->assertEquals($result, "olleh@GOOGLE.COM");
    }

    public function testBooleanVariables() {
        $exp1 = "(a or b) and c";
        $result1 = $this->calculator->isTrue($exp1, ['a' => true, 'b' => false, 'c' => true]);

        $exp2 = "(a and b) or c";
        $result2 = $this->calculator->isFalse($exp2, ['a' => false, 'b' => false, 'c' => false]);

        $this->assertEquals($result1, true);
        $this->assertEquals($result2, true);
    }

    public function testNumberVariables() {
        $exp1 = "a * 3 + b / 5";
        $result1 = $this->calculator->number($exp1, ['a' => 9, 'b' => 40]);

        $exp2 = "a * 3.222 + 88.55 / 5";
        $result2 = $this->calculator->number($exp2, ['a' => 9, 'b' => 40]);

        $this->assertEquals($result1, 35);
        $this->assertEquals($result2, 46.708);
    }
}