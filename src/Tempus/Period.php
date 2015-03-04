<?php
namespace Tempus;

class Period {

    /** @var DateTime */
    private $from;
    /** @var DateTime */
    private $to;
    private $day_saving_adjust = 0;
    private $exclude_adjust = 0;
    private $dates_to_exclude = [];
    private $week_mask = [1,1,1,1,1,1,1];


    function __construct(DateTime $from, DateTime $to, $week_mask = [1,1,1,1,1,1,1])
    {
        $this->from = $from;
        $this->to = $to;
        $this->week_mask = $week_mask;

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
        $this->dates_to_exclude[$date->format("Y-m-d")] = $date;
        return $this;
    }

    public function excludePeriod(Period $period_to_exclude)
    {
        // TODO
    }

    public function getNumDays()
    {
        $tmp_ajust = 0;
        if($this->to instanceof Date)
            $tmp_ajust = 86400;

        foreach($this->dates_to_exclude as $date_to_exclude) {
            /** @var Date $date_to_exclude */
            if($this->isDateIncluded($date_to_exclude)) {
                $dow = $date_to_exclude->format("w");
                if($this->week_mask[$dow])
                    $tmp_ajust -= $date_to_exclude->getLengthInSeconds();
            }
        }

        $done = false;
        $tmp = clone($this->from);
        $seconds_in_period = 0;
        while(!$done) {
            $dow = $tmp->format("w");
            if($this->week_mask[$dow]) {
                echo $tmp->format("Y-m-d")." ".$tmp->getLengthInSeconds()."\n";
                $seconds_in_period += $tmp->getLengthInSeconds();
            }


            $tmp->modify("+1 day");
            if($tmp->getTimestamp() >= $this->to->getTimestamp())
                $done = true;
        }

        //echo "($seconds_in_period + $tmp_ajust + ".$this->day_saving_adjust.")";
        $this->day_saving_adjust = 0;
        return ($seconds_in_period + $tmp_ajust + $this->day_saving_adjust) / 86400;
    }

    public function getNumNights()
    {
        return $this->getNumDays() - 1;
    }

}
