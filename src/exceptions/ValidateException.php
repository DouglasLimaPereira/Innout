<?php

class ValidateException extends AppException{
    private $errors = [];
    public function __construct($errors = [], $message = 'Erros Validação', $code = 0, $previus = null)
    {
        parent::__construct($message, $code, $previus);
        $this->errors = $errors;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function get($att){
        return $this->errors[$att];
    }
} 