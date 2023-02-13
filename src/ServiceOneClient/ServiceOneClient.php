<?php

declare(strict_types=1);

namespace App\ServiceOneClient;

use App\Gateway\AbstractHttpClient;
use App\Model\ServiceOne\UpdateSettingRequest;
use App\ServiceOneClient\Model\Setting;

class ServiceOneClient extends AbstractHttpClient
{
    public function get(): Setting
    {
        $response = $this->request('GET', '/service/one/setting');

        return $this->mapping($response->getContent(), Setting::class);
    }

    public function update(UpdateSettingRequest $updateSettingRequest)
    {
        $json = $this->serializer->serialize($updateSettingRequest, 'json');

        $options = [
            'body' => $json
        ];

        $response = $this->request('PUT', '/service/one/setting', $options);

        return $this->mapping($response->getContent(), Setting::class);
    }
}