<?php

declare(strict_types=1);

namespace App\ServiceTwoClient;

use App\Contract\Gateway\GRPCClientSettingInterface;

class ServiceTwoClientSetting implements GRPCClientSettingInterface
{

    private string $param1;

    private string $param2;


    public function __construct(/* string $param1, string $param2, ..., ... */)
    {
//        $this->$param1 = $param1;
//        $this->$param2 = $param2;
    }

    public function getParam1(): string
    {
        return $this->param1;
    }

    public function getParam2(): string
    {
        return $this->param2;
    }
}