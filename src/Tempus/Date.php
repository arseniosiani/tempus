<?php
namespace Tempus;

class Date extends DateTime
{

    function __construct($date)
    {
        parent::__construct($date);
        $this->setTime(0,0,0);
    }

    public function getLengthInSeconds() {
        $tmp = clone($this);
        return $tmp->modify("+1 day")->getTimestamp() - $this->getTimestamp();
    }

}
