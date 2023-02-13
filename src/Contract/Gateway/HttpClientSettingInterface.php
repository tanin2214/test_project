<?php

declare(strict_types=1);

namespace App\Contract\Gateway;

interface HttpClientSettingInterface
{
    public function getBaseUrl(): string;

    public function getTimeout(): float;
}