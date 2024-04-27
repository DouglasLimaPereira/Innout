<?php

function getDateAsDatetime($date) {
    return is_string($date) ? date('Y-m-d', strtotime($date)) : $date;
}

function isWeekend($date){
    $inputDate = getDateAsDatetime($date);
    if ($weekend = date('N',strtotime($inputDate)) >= 6) {
        return $weekend;
    }
}

function isBefore($date1, $date2){
    $inputDate1 = getDateAsDatetime($date1);
    $inputDate2 = getDateAsDatetime($date2);
    if ($before = $inputDate1 <= $inputDate2) {
        return $before;
    }
}

function getNextDay($date){
    $inputDate = getDateAsDatetime($date);
    $inputDate = date('Y-m-d', strtotime($inputDate . ' +1 day'));
    return $inputDate;
}

function getFirstMonthDay($date){
    $date = getDateAsDatetime($date);
    return new DateTime(date('Y-m-1', strtotime($date)));
}

function getLastMonthDay($date){
    $date = getDateAsDatetime($date);
    return new DateTime(date('Y-m-t', strtotime($date)));
}

function getSecondsFromDateInterval($interval){
    $intervalo = new DateInterval('PT0S');
    $intervalo->createFromDateString($interval);
   
    $d1 = new DateTimeImmutable();
    $d2 = $d1->add($intervalo);
    $soma = $d2->getTimestamp() - $d1->getTimestamp(); 
    
    return $soma;
}

function isPastWorkDay($date) {
    return !isWeekend($date) && isBefore($date, new DateTime());
}

function getTimeStringFromSeconds($seconds){
    $h = intdiv($seconds, 3600);
    $m = intdiv($seconds %3600 , 60);
    $s = $seconds - ($h * 3600) - ($m * 60); 
    return sprintf('%02d:%02d:%02d', $h, $m, $s);
}

function formatDateWithLocale($date, $pattern) {
    // $time = getDateAsDatetime($date)->getTimestamp();
    // var_dump($date);
    return date($pattern, strtotime($date));
}