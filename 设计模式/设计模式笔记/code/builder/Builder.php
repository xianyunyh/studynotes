<?php
namespace  DP\builder;
/**
 * Created by PhpStorm.
 * Date: 2018/2/9
 * Time: 15:38
 */
interface Builder {

    public function createA();
    public function createB();
    public function createC();
    public function getProduct();
}