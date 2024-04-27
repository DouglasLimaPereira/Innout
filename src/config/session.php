<?php

function sessionValidate($requiresAdmin = false) {
    $user = $_SESSION['user'];
    if (!isset($user)) {
        header('Location: login.php');
        exit();
    }elseif(($requiresAdmin == true) && (!$user->is_admin)) {
        addErrorMSG('Acesso negado!');
        header('Location: painel.php');
        exit();
    }
} 