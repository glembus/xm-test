<?php

declare(strict_types=1);

namespace App\Messenger;

interface MessageDataInterface
{
    public function getTitle(): string;

    public function getEmail(): string;

    public function getEmailTemplateData(): array;

    public function getEmailTemplate(): string;
}
