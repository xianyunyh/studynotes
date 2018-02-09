<?php

/**
 * Created by PhpStorm.
 * Date: 2018/2/8
 * Time: 17:34
 */
class ConcreteSubject implements Subject {
    private $_observers = array();
    public function attach(Observer $observer) {
        $key = spl_object_hash($observer);
        if(!empty($this->_observers[$key])) {
            $this->_observers[$key] = $observer;
        }
    }

    public function detach(Observer $observer) {

        $key = spl_object_hash($observer);

        if(!empty($this->_observers[$key])) {
            unset($this->_observers[$key]);
        }

    }

    public function notify() {
        if(!empty($this->_observers)) {
            foreach ($this->_observers as $observer) {
                $observer->update();
            }
        }
    }

}