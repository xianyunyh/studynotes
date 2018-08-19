<?php
/**
 * Created by PhpStorm.
 * Date: 2018/2/9
 * Time: 15:41
 */

namespace DP\builder;


class Director {

    public function build( Builder $build)
    {
        $build->createA();
        $build->createB();
        $build->createC();
        return $build->getProduct();
    }
}