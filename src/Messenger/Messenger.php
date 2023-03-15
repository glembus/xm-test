<?php

declare(strict_types=1);

namespace App\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class Messenger implements MessengerInterface
{
    public function __construct(private readonly MailerInterface $mailer, private readonly LoggerInterface $logger)
    {
    }

    public function send(MessageDataInterface $messageData): void
    {
        $email = new TemplatedEmail();
        $email
            ->to($messageData->getEmail())
            ->htmlTemplate($messageData->getEmailTemplate())
            ->subject($messageData->getTitle())
            ->from('TstApp <admin@test.domain>')
            ->context($messageData->getEmailTemplateData());
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage(), ['sContext' => $e->getTraceAsString()]);
        }
    }
}
