<?php

declare(strict_types=1);

namespace App\Controller\ServiceThree;

use App\Controller\BaseController;
use App\Model\ServiceThree\UpdateSettingRequest;
use App\Result\ItemResult;
use App\Result\SuccessResult;
use App\ServiceThreeClient\ServiceThreeClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingsController extends BaseController
{
    public function getSettings(ServiceThreeClient $serviceThreeClient): JsonResponse
    {
        $settings = $serviceThreeClient->get();

        return $this->jsonResult(new ItemResult($settings));
    }

    public function updateSettings(UpdateSettingRequest $updateSettingRequest, ServiceThreeClient $serviceThreeClient): JsonResponse
    {
        $serviceThreeClient->update($updateSettingRequest);

        return $this->jsonResult(new SuccessResult());
    }

}