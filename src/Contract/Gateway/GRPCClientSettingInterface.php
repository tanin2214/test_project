<?php

declare(strict_types=1);

namespace App\Contract\Gateway;

interface GRPCClientSettingInterface
{
    public function getParam1(): string;

    public function getParam2(): string;
}