<?php
class Month {
    public $start_date;
    public $end_date;
    
    function __construct($year, $month) {
        $this->start_date = "$year-$month-01";
        $daysInMonth = date("t", strtotime("$year-$month-01"));
        $this->end_date = "$year-$month-$daysInMonth";
    }
}
?>
