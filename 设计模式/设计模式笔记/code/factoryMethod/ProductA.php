<?php
/**
 * Created by PhpStorm.
 * Date: 2018/2/9
 * Time: 14:13
 */

namespace DP\factoryMethod;

class ProductA extends ConcreteProduct {

    public function setColor($color) {
        $this->color= 'black';
    }
}