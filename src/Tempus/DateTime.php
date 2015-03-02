<?php
namespace Tempus;

class DateTime
{
    protected $date;

    function __construct($date)
    {
        $this->date = new \DateTime($date);
        $this->date->setTime(0,0,0);
    }

    public function format($format)
    {
        return $this->date->format($format);
    }

    public function addDays($num)
    {
        $this->date->modify("+$num days");
        return $this;
    }

    public function subDays($num)
    {
        $this->date->modify("-$num days");
        return $this;
    }

    public function modify($modify)
    {
        $this->date->modify($modify);
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->date;
    }


}
