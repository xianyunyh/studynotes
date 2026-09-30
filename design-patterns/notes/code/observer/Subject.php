<?php

/**
 * Created by PhpStorm.
 * Date: 2018/2/8
 * Time: 17:09
 */
interface Subject {

    public  function attach(Observer $observer);

    public  function detach(Observer $observer);

}
