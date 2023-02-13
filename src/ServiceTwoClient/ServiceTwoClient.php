<?php

declare(strict_types=1);

namespace App\ServiceTwoClient;

use App\Gateway\AbstractGRPCClient;
use App\Model\ServiceTwo\UpdateSettingRequest;
use App\ServiceOneClient\Model\Setting;

class ServiceTwoClient extends AbstractGRPCClient
{
    public function get(): Setting
    {
        //TODO логика получения
        $response = $this->callRemoteProcedure(/* args */);

        return $this->serializer->deserialize($response->getContent(), Setting::class, 'json');
    }

    public function update(UpdateSettingRequest $updateSettingRequest) /* : object */
    {
        return $this->callRemoteProcedure(/* args */);
    }
}