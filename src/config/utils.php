<?php

function addSuccessMSG($msg) {
    $_SESSION['message'] = [
        'type' => 'success',
        'message' => $msg
    ];
}

function addErrorMSG($msg) {
    $_SESSION['message'] = [
        'type' => 'error',
        'message' => $msg
    ];
}
