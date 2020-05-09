<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 23/09/18
 * Time: 18:16
 */

namespace App\Model;


class Person
{
    private $name;

    private $adress;

    public function __construct(Adress $adress)
    {
        $this->name = uniqid();
        $this->adress = $adress;
    }
}