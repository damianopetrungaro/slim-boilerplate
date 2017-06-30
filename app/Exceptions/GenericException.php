<?php

declare(strict_types=1);

namespace App\Exceptions;

class GenericException extends \Exception
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var int
     */
    private $status;
    /**
     * @var string
     */
    private $details;

    /**
     * GenericException constructor.
     *
     * @param string $title
     * @param string $details
     * @param int $status
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $title, string $details, int $status, $code = 0, \Exception $previous = null)
    {
        $this->title = $title;
        $this->details = $details;
        $this->status = $status;
        parent::__construct($title, $code, $previous);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetails(): string
    {
        return $this->details;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
