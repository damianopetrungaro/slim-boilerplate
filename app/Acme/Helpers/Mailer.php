<?php

namespace App\Acme\Helpers;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mailer
{
    public static function send($subject, array $to, $body)
    {
        $transport = Swift_SmtpTransport::newInstance(getenv('SMTP_HOST'), getenv('SMTP_PORT'), getenv('SMTP_ENCRYPTION'))
            ->setUsername(getenv('SMTP_USERNAME'))
            ->setPassword(getenv('SMTP_PASSWORD'));

        $message = Swift_Message::newInstance($subject)
            ->setFrom([getenv('SMTP_USERNAME') => getenv('SMTP_NAME')])
            ->setTo($to)
            ->setBody($body);

        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }
}
