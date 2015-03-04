<?php
namespace Tempus;

class DateTime extends \DateTime
{
    protected $date;

    function __construct($date, $timezone = null)
    {
        if(is_numeric($date)) {
            $date = date("Y-m-d H:i:s", $date);
        }

        parent::__construct($date,$timezone);
    }

    public function addDays($num)
    {
        $this->modify("+$num days");
        return $this;
    }

    public function subDays($num)
    {
        $this->modify("-$num days");
        return $this;
    }

    function __toString() {
        return $this->format("Y-m-d H:i:s");
    }
}
