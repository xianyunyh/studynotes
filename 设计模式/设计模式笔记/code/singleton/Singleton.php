<?php

namespace DP\singleton;

class Singleton {

    private static $_instance;

    private function __construct() {

    }

    private function __clone() {

    }


    /**
     * @return Singleton
     */
    public static function getInstance() {
        if (!self::$_instance instanceof Singleton) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}

$s1 = Singleton::getInstance();
$s2 = Singleton::getInstance();

var_dump($s1 === $s2);