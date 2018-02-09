<?php

namespace DP\simpleFactory;
/**
 * Created by PhpStorm.
 * Date: 2018/2/7
 * Time: 10:51
 */
class Factory {

    public function create($name) {
        if ($name == 'A') {
            return new ProductA();
        }
        if ($name == 'B') {
            return new ProductB();
        }

        throw new Exception('ERROR:NO CLASS FOND');
    }
}