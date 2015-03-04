<?php
namespace Tempus;

class Dates extends \ArrayIterator {


    function __construct() {
        parent::__construct();
    }

    public function addDate(Date $date) {
        $this->append($date);
    }

    function __toString() {
        return implode(",", (array)$this);
    }


}
