<?php

namespace Billetterie\BilletterieBundle\Services;


class MailService
{
    public function getMailService($bodyEmail, $panier)
    {
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername('geteolastpiece')
            ->setPassword('bmpmpnxqojewxlxc');
        //création d'un objet mailer
        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance();
        $message->setSubject("Billet pour votre visite du Louvre");
        $message->setFrom('geteolastpiece@gmail.com');
        $message->setTo($panier->getMail());
        // pour envoyer le message en HTML
        $message->setBody($bodyEmail,'text/html');
        //envoi du message
        $mailer->send($message);
    }
}