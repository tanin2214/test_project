<?php

declare(strict_types=1);

namespace App\ServiceThreeClient;

use App\Contract\Gateway\HttpClientSettingInterface;

class ServiceThreeClientSetting implements HttpClientSettingInterface
{
    private string $baseUrl;

    private float $timeout;

    public function __construct(string $baseUrl, float $timeout)
    {
        $this->baseUrl = $baseUrl;
        $this->timeout = $timeout;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }
}