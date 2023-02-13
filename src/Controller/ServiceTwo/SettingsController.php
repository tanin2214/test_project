<?php

namespace App\Controller\ServiceTwo;

use App\Controller\BaseController;
use App\Model\ServiceTwo\UpdateSettingRequest;
use App\Result\ItemResult;
use App\Result\SuccessResult;
use App\ServiceTwoClient\ServiceTwoClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends BaseController
{
    public function getSettings(ServiceTwoClient $serviceOneClient): JsonResponse
    {
        $settings = $serviceOneClient->get();

     return $this->jsonResult(new ItemResult($settings));
    }

    public function updateSettings(UpdateSettingRequest $updateSettingRequest, ServiceTwoClient $serviceOneClient): JsonResponse
    {
        $serviceOneClient->update($updateSettingRequest);

        return $this->jsonResult(new SuccessResult());
    }
}