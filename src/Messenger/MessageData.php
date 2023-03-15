<?php

declare(strict_types=1);

namespace App\Messenger;

class MessageData implements MessageDataInterface
{
    public function __construct(
        private readonly string $title,
        private readonly string $email,
        private readonly array $emailBodyData,
        private readonly string $emailTemplate,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailTemplateData(): array
    {
        return $this->emailBodyData;
    }

    public function getEmailTemplate(): string
    {
        return $this->emailTemplate;
    }
}
