<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 03/10/18
 * Time: 23:01
 */

namespace App\Model;


use App\Model\Person;

class City
{
    /**
     * @var Person
     */
    private $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }
}