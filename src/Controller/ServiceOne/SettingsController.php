<?php

declare(strict_types=1);

namespace App\Controller\ServiceOne;

use App\Controller\BaseController;
use App\Model\ServiceOne\UpdateSettingRequest;
use App\Result\ItemResult;
use App\Result\SuccessResult;
use App\ServiceOneClient\ServiceOneClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingsController extends BaseController
{
    public function getSettings(ServiceOneClient $serviceOneClient): JsonResponse
    {
        $settings = $serviceOneClient->get();

        return $this->jsonResult(new ItemResult($settings));
    }

    public function updateSettings(UpdateSettingRequest $updateSettingRequest, ServiceOneClient $serviceOneClient): JsonResponse
    {
        $serviceOneClient->update($updateSettingRequest);

        return $this->jsonResult(new SuccessResult());
    }
}