<?php

declare(strict_types=1);

namespace App\Controller;

use App\Result\ResultInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array<string, string> $headers
     */
    protected function jsonResult(ResultInterface $result, array $headers = []): JsonResponse
    {
        $json = $this->serializer->serialize($result->getData(), 'json');

        return new JsonResponse($json, 200, $headers, true);
    }

}