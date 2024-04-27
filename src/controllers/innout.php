<?php
session_start();
sessionValidate();

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

try {
    $currentTime = date("H:i:s");

    if (isset($_POST['forcedTime'])) {
        $currentTime = $_POST['forcedTime'];
    }

    $records->innout($currentTime);
    
    addSuccessMSG('Ponto inserido com sucesso!');
} catch (AppException $e) {
    addErrorMSG($e->getMessage());
}

header("Location: painel.php");