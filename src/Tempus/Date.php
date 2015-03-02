<?php
/**
 * Created by WeBeetle snc.
 * User: zulin
 * Date: 02/03/15
 * Time: 18:50
 */

namespace Tempus;

class Date extends DateTime
{

    function __construct($date) {
        parent::__construct($date);
        $this->date->setTime(0,0,0);
    }

    public function format($format) {
        return $this->date->format($format);
    }

    public function getDateTime()
    {
        return $this->date;
    }


}
