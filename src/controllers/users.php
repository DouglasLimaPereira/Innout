<?php
session_start();
sessionValidate(true);

$exception = null;
if (isset($_GET['delete'])) {
    try {
        User::deleteById($_GET['delete']);
        addSuccessMSG('Usuário removido com sucesso!');
    } catch (Exception $e) {
        if (stripos($e->getMessage(), 'FOREIGN KEY')) {
            addErrorMSG('Não é possível remover usuário com registros no banco');    
        }else {

            $exception = $e;
        }
    }
}

$users = User::get();

foreach ($users as $key => $user) {
    $user->start_date = date('d/m/Y', strtotime($user->start_date)); 
    $user->end_date = date('d/m/Y', strtotime($user->end_date)); 
}

loadTemplateView('users', [
    'users' => $users,
    'exception' => $exception,
]);