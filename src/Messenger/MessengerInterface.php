<?php

namespace App\Messenger;

interface MessengerInterface
{
    public function send(MessageDataInterface $messageData): void;
}
