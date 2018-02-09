<?php

/**
 * Created by PhpStorm.
 * Date: 2018/2/8
 * Time: 17:27
 */
class ConcreteObserver implements Observer {

    public function update() {
        echo __CLASS__."update";
    }

}