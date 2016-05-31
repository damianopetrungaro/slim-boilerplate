<?php

namespace App\Exceptions;

class GenericException extends \Exception
{
    private $title;
    private $status;
    private $details;

    public function __construct($title, $details, $status, $code = 0, \Exception $previous = null)
    {
        $this->title = $title;
        $this->details = $details;
        $this->status = $status;
        parent::__construct($title, $code, $previous);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
