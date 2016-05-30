<?php

namespace App\Exceptions;

class JWTException extends \Exception
{
    private $title;

    public function __construct($title, $message, $code)
    {
        $this->title = $title;
        parent::__construct($message, $code);
    }

    public function getTitle()
    {
        return $this->title;
    }
}
