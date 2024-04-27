<?php
Database::executeSQL('DELETE FROM working_hours');
Database::executeSQL('DELETE FROM users WHERE id > 5');

function getDayTemplateByOdss($regularRate, $extraRate, $lazyRate) {
    $regularDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '11:00:00',
        'time3' => '12:00:00',
        'time4' => '15:20:00',
        'worked_time' => DAILY_TIME,
    ];
    
    $extraHourDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '11:00:00',
        'time3' => '12:00:00',
        'time4' => '16:20:00',
        'worked_time' => DAILY_TIME + 3600,
    ];
    
    $lazyDayTemplate = [
        'time1' => '08:30:00',
        'time2' => '11:00:00',
        'time3' => '12:00:00',
        'time4' => '15:20:00',
        'worked_time' => DAILY_TIME - 1800,
    ];

    $value = rand(0, 100);
    if ($value <= $regularRate) {
        return $regularDayTemplate;
    } elseif ($value <= $regularRate + $extraRate) {
        return $extraHourDayTemplate;
    } else {
        return $lazyDayTemplate;
    }
}

function populateWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate) {
    $currentDate = $initialDate;
    $today = date('Y-m-d', strtotime('now'));
    $today = date('Y-m-d', strtotime($today.'-1 day'));
    $columns = ['user_id' => $userId, 'work_date' => $currentDate];
    
    while (isBefore($currentDate, $today)) {
        if (!(isWeekend($currentDate))) {
            
            $template = getDayTemplateByOdss($regularRate, $extraRate, $lazyRate);
            $columns = array_merge($columns, $template);
            $workingHours = new WorkingHours($columns);
            $workingHours->insert();
        }
        $currentDate = getNextDay(date('Y-m-d', strtotime($currentDate)));
        $columns['work_date'] = $currentDate;
    }
}

$lastMonth = strtotime('first day of last month');
populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);
populateWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
populateWorkingHours(4, date('Y-m-d', $lastMonth), 20, 10, 70);
