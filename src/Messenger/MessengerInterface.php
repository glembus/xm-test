<?php

declare(strict_types=1);

namespace App\Messenger;

interface MessengerInterface
{
    public function send(MessageDataInterface $messageData): void;
}
