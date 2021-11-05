<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class MailerController extends AbstractController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('keskonmate@gmail.com')
            ->to('keskonmate@gmail.com')
            // ->cc('alexisbertell@gmail.com', 'dorian.lalanne@yahoo.fr', 'wuwuceline@gmail.com', 'eddyzsoma@gmail.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('COUCOU!!!!!');

        $mailer->send($email);
    }
}