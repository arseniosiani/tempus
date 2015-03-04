<?php
namespace Tempus\Holidays;

use Tempus\Date;
use Tempus\Dates;

abstract class HolidaysAbstract {
    /**
     * @param $year
     * @return Dates
     */
    public function getHolyDaysInYear($year) {
        $dates = new Dates();
        foreach($this->holydays($year) as $timestamp) {
            $dates->addDate(new Date($timestamp));
        }
        return $dates;
    }

    abstract protected function holydays($year);

}
