<?php

session_start();
sessionValidate();

$date = new DateTime('now');
$today = date('d \\d\e M \\d\e Y', strtotime('now'));

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
loadTemplateView('day_records', ['today' => $today, 'records' => $records]);