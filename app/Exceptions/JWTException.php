<?php

declare(strict_types=1);

namespace App\Exceptions;

class JWTException extends \Exception
{
    /**
     * @var string
     */
    private $title;

    public function __construct(string $title, string $message, $code = null)
    {
        $this->title = $title;
        parent::__construct($message, $code);
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
