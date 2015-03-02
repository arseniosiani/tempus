<?php
namespace Tempus;

class Period {

    private $from;
    private $to;

    function __construct(\DateTime $from, \DateTime $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function excludeDates(Dates $dates)
    {
        // TODO
    }

    public function excludeDate(Date $date)
    {
        // TODO
    }

    public function excludePeriod(Period $period_to_exclude)
    {
        // TODO
    }

    public function includePeriod(Period $period_to_include)
    {
        // TODO
    }

    public function getNumDays()
    {
        // TODO
    }

    public function getNumNights()
    {
        // TODO
    }


}
