<?php
/**
 * Created by PhpStorm.
 * Date: 2018/2/9
 * Time: 14:09
 */

namespace DP\factoryMethod;


class ConcreteProduct extends Product {

    protected $color;

    public function setColor($color) {
        $this->color = $color;
    }
}