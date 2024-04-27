<?php 
    $errors = [];

    if (isset($_SESSION['message']) ) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }

    if (isset($exception)) {
        $message = [
            'type' => 'error',
            'message' => $exception->getMessage(),
        ];
        
        if(get_class($exception) === 'ValidateException') {
            $errors = $exception->getErrors();
        }   
    }

    $alertType = '';
    if (isset($message['type']) === 'error') {
        $alertType = 'danger';
    } else if (isset($message['type']) === '') {
        $alertType = 'danger';
    } else {
        $alertType = 'success';
    }
?>

<?php if(isset($message)): ?>
    <div class="my-3 alert alert-<?=$alertType?>" role="alert">
        <?= $message['message'] ?>
    </div>
<?php endif ?>
