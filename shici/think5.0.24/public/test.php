<?php

class A {
    public $a = 55;

    public static function getInstance() {
        return new self;
    }

    public static function getInstance2() {
        return new static;
    }
}


class B extends A {
    public $a = 66;
}


$n = A::getInstance();

$n2 = A::getInstance2();

$n3 = B::getInstance();

$n4 = B::getInstance2();

echo $n->a.'<br>';
echo $n2->a.'<br>';
echo $n3->a.'<br>';
echo $n4->a.'<br>';


