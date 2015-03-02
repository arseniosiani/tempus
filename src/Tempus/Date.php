<?php
namespace Tempus;

class Date extends DateTime
{

    function __construct($date)
    {
        parent::__construct($date);
        $this->date->setTime(0,0,0);
    }

}
