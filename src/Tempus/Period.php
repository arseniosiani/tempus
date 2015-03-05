<?php
namespace Tempus;

use Tempus\Holidays\HolidaysAbstract;

class Period {

    /** @var DateTime */
    private $from;
    /** @var DateTime */
    private $to;
    private $day_saving_adjust = 0;
    private $exclude_adjust = 0;
    /** @var Dates */
    private $dates_to_exclude;
    private $week_mask = [1,1,1,1,1,1,1];
    /** @var HolidaysAbstract  */
    private $holidays_to_exclude = null;


    function __construct(DateTime $from, DateTime $to, $week_mask = [1,1,1,1,1,1,1])
    {
        $this->from = $from;
        $this->to = $to;
        $this->week_mask = $week_mask;
        $this->dates_to_exclude = new Dates();

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

    public function excludeHolidays(HolidaysAbstract $holydays)
    {
        $this->holidays_to_exclude = $holydays;
    }

    public function excludeDate(Date $date)
    {
        $this->dates_to_exclude->append($date);
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

        $dates_to_exclude = clone($this->dates_to_exclude);
        if($this->holidays_to_exclude) {
            $dates_to_exclude->addDates($this->holidays_to_exclude->getHolyDaysInYear($this->from->format("Y")));
            if($this->from->format("Y") != $this->to->format("Y")) {
                $dates_to_exclude->addDates($this->holidays_to_exclude->getHolyDaysInYear($this->to->format("Y")));
            }
        }

        foreach($dates_to_exclude as $date_to_exclude) {
            /** @var Date $date_to_exclude */
            if($this->isDateIncluded($date_to_exclude)) {
                $dow = $date_to_exclude->format("w");
                if($this->week_mask[$dow])
                    $tmp_ajust -= $date_to_exclude->getLengthInSeconds();
            }
        }

        $done = false;
        $tmp = clone($this->from);
        $num_days = 0;
        while(!$done) {
            $dow = $tmp->format("w");
            if($this->week_mask[$dow]) {
                if(!$dates_to_exclude->contains($tmp))
                    $num_days++;
            }

            $tmp->modify("+1 day");
            if($tmp->getTimestamp() > $this->to->getTimestamp())
                $done = true;
        }

        return $num_days;
    }

    public function getNumNights()
    {
        return $this->getNumDays() - 1;
    }

}
