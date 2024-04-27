<?php
session_start();
sessionValidate(true);

$activeUsersCount = User::getActiveUsersCount();
$absentUsers = WorkingHours::getAbsentUsers();

$date = (new DateTime())->format('Y-m');
$seconds = WorkingHours::getWorkedTimeInMonth($date);
$workedTimeInMonth = explode(':', getTimeStringFromSeconds($seconds))[0];

loadTemplateView('manager_report', [
    'activeUsersCount' => $activeUsersCount,
    'absentUsers' => $absentUsers, 
    'workedTimeInMonth' => $workedTimeInMonth,
]);