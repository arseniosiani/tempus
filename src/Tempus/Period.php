<?php
namespace Tempus;

class Period {

    private $from;
    private $to;
    private $day_saving_adjust = 0;
    private $exclude_adjust = 0;

    function __construct(\DateTime $from, \DateTime $to)
    {
        $this->from = $from;
        $this->to = $to;

        if($this->from->format("I") != $this->to->format("I")) {
            $this->day_saving_adjust = 3600;
            if($this->from->format("I"))
                $this->day_saving_adjust = -3600;
        }
    }

    public function isDateIncluded(Date $date) {
        if($date->getTimestamp() >= $this->from->getTimestamp() && $date->getTimestamp() <= $this->to->getTimestamp())
            return true;
        return false;
    }

    public function excludeDates(Dates $dates)
    {
        foreach($dates as $date)
            $this->excludeDate($date);
        return $this;
    }

    public function excludeDate(Date $date)
    {
        if($this->isDateIncluded($date)) {
            $this->exclude_adjust -= $date->getLengthInSeconds();
        }

        return $this;
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
        $from_time_stamp = $this->from->getTimestamp();
        $to_time_stamp = $this->to->getTimestamp();

        $tmp_ajust = 0;
        if($this->to instanceof Date)
            $tmp_ajust = 86400;
        // return ($to_time_stamp - $from_time_stamp) / 86400;
        return ($to_time_stamp - $from_time_stamp + $tmp_ajust + $this->day_saving_adjust + $this->exclude_adjust) / 86400;
    }

    public function getNumNights()
    {
        // TODO
    }

}
