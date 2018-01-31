<?php

namespace App\ShowCaseBundle\Manager;



class MailerManager
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($view, $object, $from, $to, $type = 'text/html')
    {
        $message = (new \Swift_Message($object))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $view,
                $type
            )
        ;

        $this->mailer->send($message);
    }
}