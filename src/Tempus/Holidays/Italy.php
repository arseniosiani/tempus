<?php
namespace Tempus\Holidays;

class Italy extends HolidaysAbstract {

    protected function holydays($year) {
        return [
            'capodanno'     => $this->holydayCapodanno($year),
            'befana'        => $this->holydayEpifania($year),
            'pasqua'        => $this->holydayPasqua($year),
            'pasquetta'     => $this->holydayPasquetta($year),
            'liberazione'   => $this->holydayLiberazione($year),
            'festaDelLavoro'=> $this->holydayFestaDelLavoro($year),
            'festaRepublica'=> $this->holydayRestaRepublica($year),
            'ferragosto'    => $this->holydayFerragosto($year),
            'ognissanti'    => $this->holydayOgnissanti($year),
            'immacolata'    => $this->holydayImmacolata($year),
    		'natale'        => $this->holydayNatale($year),
	    	'santoStefano'  => $this->holydaySantoStefano($year)
        ];
    }

    protected function holydayCapodanno($year) {
        return mktime(0,0,0,1,1,$year);
    }

    protected function holydayPasquetta($year) {
        return $this->holydayPasqua($year)+86400;
    }

    protected function holydayNatale($year) {
        return mktime(0,0,0,12,25,$year);
    }

    protected function holydaySantoStefano($year) {
        return mktime(0,0,0,12,26,$year);
    }

    protected function holydayEpifania($year) {
        return mktime(0,0,0,1,6,$year);
    }

    protected function holydayLiberazione($year) {
        return mktime (0,0,0,4,25,$year);
    }

    protected function holydayFestaDelLavoro($year) {
        return mktime(0,0,0,5,1,$year);
    }

    protected function holydayRestaRepublica($year) {
        return mktime (0,0,0,6,2,$year);
    }

    protected function holydayFerragosto($year) {
        return mktime(0,0,0,8,15,$year);
    }

    protected function holydayOgnissanti($year) {
        return mktime(0,0,0,11,1,$year);
    }

    public function holydayImmacolata($year) {
        return mktime(0,0,0,12,8,$year);
    }

    protected function holydayPasqua($year) {
        $offset = mktime(0,0,0,3,21,$year);

        if (function_exists('easter_days')) {
            return $offset + (easter_days($year)*86400);
        }

        $julianOffset = 13;
        if ($year > 2100) {
            $julianOffset = 14;
        }
        $a = $year % 19;
        $b = $year % 4;
        $c = $year % 7;
        $ra = (19 * $a + 16);
        $r4 = $ra % 30;
        $rb = 2 * $b + 4 * $c + 6 * $r4;
        $r5 = $rb % 7;
        $rc = $r4 + $r5 + $julianOffset;

        return $offset + ($rc * 86400);
    }

}
