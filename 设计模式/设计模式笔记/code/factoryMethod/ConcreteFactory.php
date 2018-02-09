<?php
/**
 * Created by PhpStorm.
 * Date: 2018/2/9
 * Time: 14:07
 */

namespace DP\factoryMethod;


class ConcreteFactory extends FactoryMethod {

    public function create($type) {

        if($type == 'A') return new ProductA();
    }
}