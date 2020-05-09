<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 23/09/18
 * Time: 18:16
 */

namespace App\Model;


class Adress
{
    private $adress;

    public function __construct()
    {
        $this->adress = uniqid();
    }

    /**
     * @return String
     */
    public function getAdress(): String
    {
        return $this->adress;
    }

    /**
     * @param String $adress
     */
    public function setAdress(String $adress): void
    {
        $this->adress = $adress;
    }
}