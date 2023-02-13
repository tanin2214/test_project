<?php

declare(strict_types=1);

namespace App\ServiceThreeClient;

use App\Gateway\AbstractHttpClient;
use App\Model\ServiceThree\UpdateSettingRequest;
use App\ServiceOneClient\Model\Setting;

class ServiceThreeClient extends AbstractHttpClient
{
    public function get(): Setting
    {
//        $settings = $this->request(....);
        //Получение настроек с удаленного сервера
        return new Setting();
    }

    public function update(UpdateSettingRequest $updateSettingRequest)
    {
        //        $this->request(....);
        //Обновление настроек с удаленного сервера
    }
}