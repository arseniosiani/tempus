<?php
namespace Tempus;

class DateTime
{
    protected $date;

    function __construct($date)
    {
        if(is_numeric($date)) {
            $date = date("Y-m-d H:i:s", $date);
        }

        $this->date = new \DateTime($date);
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

    function __toString() {
        return $this->format("Y-m-d H:i:s");
    }


}
