<?php


namespace model;


use Exception;

class MyException extends Exception
{
    private array $messages = ['Неверные данные', 'Недопустимые символы в логине', 'Недопустимые символы в пароле'];

    public function __construct($code = 0)
    {
        switch ($code){
            case 1: $message = $this->messages[1];
            break;
            case 2: $message = $this->messages[2];
            break;
            default: $message = $this->messages[0];
        }
        parent::__construct($message);
    }
}