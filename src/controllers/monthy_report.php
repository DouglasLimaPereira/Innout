<?php
session_start();
sessionValidate();

$user = $_SESSION['user'];
$selectedUser = $user->id;
$users = null;
if ($user->is_admin) {
    $users = User::get();
    $selectedUser = $_POST['user'] ? $_POST['user'] : $user->id;
}

$selectPeriod = $_POST['period'] ? $_POST['period'] : $currentDate;
$periods = [];
for ($yearDiff = 0; $yearDiff <=2 ; $yearDiff ++) { 
    $year = date('Y') - $yearDiff;
    for ($month = 12; $month >= 1 ; $month--) { 
        
        $date = new DateTime("{$year}-{$month}-1");
        
        $formatter = new IntlDateFormatter(
        'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Fortaleza',          
            IntlDateFormatter::GREGORIAN,
        );
        
        // $periods[$date->format('Y-m')] = date('M \\d\e Y', $formatter->getTimeStamp());
        $periods[$date->format('Y-m')] =  $formatter->format($date);
        
    }
}

$currentDate = date('Y-m-d');
$registers = WorkingHours::getMonthyReport($selectedUser, $selectPeriod);


$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastMonthDay($selectPeriod);

for ($day=1; $day <= $lastDay->format('d') ; $day++) { 
    $date  = date('Y-m', strtotime($selectPeriod)) . '-' . sprintf('%02d', $day);

    $registry = $registers[$date];
    if ( isPastWorkDay($date) ) $workDay++;

    if ( $registry ) {
        $sumOfWorkedTime += $registry->worked_time; 
        array_push($report, $registry);
    } else {
        array_push($report, new WorkingHours([
            'work_date' => $date,
            'worked_time' => 0
        ]));

    }
}

$expectedTime = $workDay * DAILY_TIME;
$balance =  getTimeStringFromSeconds(abs($expectedTime - $sumOfWorkedTime));
$sign = ($expectedTime >= $sumOfWorkedTime) ? '+' : '-';

loadTemplateView('monthy_report', [
    'report' => $report,
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),
    'balance' => "{$sign} {$balance}",
    'periods' => $periods,
    'users' => $users,
    'selectPeriod' => $selectPeriod,
    'selectedUser' => $selectedUser,
]);
