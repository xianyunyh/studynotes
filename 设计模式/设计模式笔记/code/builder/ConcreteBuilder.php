<?php
/**
 * Created by PhpStorm.
 * Date: 2018/2/9
 * Time: 15:40
 */

namespace DP\builder;


class ConcreteBuilder implements Builder {

    private $product;

    public function createA() {
        $this->product->add("door",new ProductA());

    }

    public function createB() {
        return new ProductB();

    }

    public function createC() {

    }

    public function getProduct() {

    }

}