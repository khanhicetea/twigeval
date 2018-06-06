# Twigeval

**SAFE** processing expression of variables from string without using `eval` (seems to be **evil**).

## Core

Using **twig** template engine to produce the result, so you can use any twig syntax and its filters.

## Usage

```bash
$ composer require khanhicetea/twigeval
```

```php
/*
$cacheDir could be :
    - false : no use cache (mean use eval function), be carefully !
    - null : use sys_get_temp_dir() to get system temp directory as cache dir
    - string : cache directory path
*/
$cacheDir = null;
$calculator = new KhanhIceTea\Twigeval\Calculator($cacheDir);
$math = $calculator->number('a / 4 + b * 3', ['a' => 16, 'b' => 3]); // => 13
$boolean1 = $calculator->isTrue('(a and b) or c', ['a' => false, 'b' => true, 'c' => false]); // => false
$boolean2 = $calculator->isFalse('(a and b) or c', ['a' => false, 'b' => true, 'c' => false]); // => true
$string = $calculator->calculate('{{ a|reverse }} world !', ['a' => 'hello']); // => olleh world !
```

## LICENSE

The MIT License (MIT)
Copyright (c) 2018 KhanhIceTea