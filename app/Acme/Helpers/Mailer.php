<?php

declare(strict_types=1);

namespace App\Acme\Helpers;

use App\Exceptions\GenericException;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mailer
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $port;
    /**
     * @var string
     */
    private $encryption;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $name;

    /**
     * Mailer constructor.
     * @param string $host
     * @param string $port
     * @param string $encryption
     * @param string $username
     * @param string $password
     * @param string $name
     */
    public function __construct(string $host, string $port, string $encryption, string $username, string $password, string $name)
    {
        $this->host = $host;
        $this->port = $port;
        $this->encryption = $encryption;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }

    /**
     * Return a Mailer from an array
     *
     * @param array $smtp
     *
     * @return Mailer
     */
    public static function fromArray(array $smtp): self
    {
        return new self(
            $smtp['host'],
            $smtp['port'],
            $smtp['encryption'],
            $smtp['username'],
            $smtp['password'],
            $smtp['name']);
    }

    /**
     * Send an email
     *
     * @param $subject
     * @param array $to
     * @param $body
     *
     * @return void
     *
     * @throws \App\Exceptions\GenericException
     */
    public function send($subject, array $to, $body)
    {
        $transport = Swift_SmtpTransport::newInstance($this->host, $this->port, $this->encryption)->setUsername($this->username)->setPassword($this->password);
        $message = Swift_Message::newInstance($subject)->setFrom([$this->username => $this->name])->setTo($to)->setBody($body);
        $mailer = Swift_Mailer::newInstance($transport);

        if ($mailer->send($message) === 0) {
            throw new GenericException('Email not sent', '', 500);
        }
    }
}
