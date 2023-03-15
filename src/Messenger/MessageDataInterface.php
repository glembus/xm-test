<?php

namespace App\Messenger;

interface MessageDataInterface
{
    public function getTitle(): string;

    public function getEmail(): string;

    public function getEmailTemplateData(): array;

    public function getEmailTemplate(): string;
}
