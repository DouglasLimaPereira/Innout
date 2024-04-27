<?php

class AppException extends Exception{
    public function __construct($message, $code = 0, $previus = null)
    {
        parent::__construct($message, $code, $previus);
    }
} 