<?php

namespace App\Tests\Unit\ServiceOneClient;

use App\Model\ServiceOne\UpdateSettingRequest;
use App\ServiceOneClient\Model\Setting;
use App\ServiceOneClient\ServiceOneClient;
use App\ServiceOneClient\ServiceOneClientSetting;
use App\Tests\Unit\ObjectsHelper;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ServiceOneClientSettingTest extends TestCase
{
    use ObjectsHelper;

    public function testGet(): void
    {
        $httpClient = $this->createMock(HttpClientInterface::class);

        $responseContent = [
            'field1' => 'field',
            'field2' => false,
            'field3' => [
                'field3.one',
                'field3.two',
                'field3.tw',
            ],
        ];

        $jsonResponseBody = json_encode($responseContent);

        $httpClient
            ->expects(self::once())
            ->method('request')
            ->with(
                'GET',
                '/service/one/setting',
                [
                    'base_uri' => '_getBaseUrl_',
                    'timeout' => 10.0,
                ]
            )
            ->willReturn($this->createResponse($jsonResponseBody));

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer
            ->expects(self::once())
            ->method('deserialize')
            ->with($jsonResponseBody, Setting::class, 'json')
            ->willReturn(new Setting);

        $client = $this->createClient($httpClient, $serializer);
        $result = $client->get();
        self::assertInstanceOf(Setting::class, $result);
    }

    public function testUpdate(): void
    {
        $settings = new UpdateSettingRequest();

        $this->setObjectProps(
            $settings,
            [
                'field1' => 'value1',
                'field2' => false,
                'field3' => [
                    'array0',
                    'array1',
                    'array2',
                ],
            ]);

        $httpClient = $this->createMock(HttpClientInterface::class);

        $responseContent = [
            'filed1' => 'value1',
            'field2' => false,
            'field3' => [
                'array0',
                'array1',
                'array2',
            ],
        ];

        $jsonResponseBody = json_encode($responseContent);

        $httpClient
            ->expects(self::once())
            ->method('request')
            ->with(
                'PUT',
                '/service/one/setting',
                [
                    'base_uri' => '_getBaseUrl_',
                    'timeout' => 10.0,
                    'body' => $jsonResponseBody,
                ]
            )
            ->willReturn($this->createResponse($jsonResponseBody));

        $serializer = $this->createMock(SerializerInterface::class);

        $serializer
            ->expects(self::once())
            ->method('serialize')
            ->with($settings, 'json')
            ->willReturn($jsonResponseBody);

        $serializer
            ->expects(self::once())
            ->method('deserialize')
            ->with($jsonResponseBody, Setting::class, 'json')
            ->willReturn(new Setting);

        $client = $this->createClient($httpClient, $serializer);
        $result = $client->update($settings);
    }

    /**
     * @return MockObject&ResponseInterface
     */
    private function createResponse(?string $content = null)
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getInfo')->willReturn(
            [
                'http_method' => 'GET',
                'url' => '',
                'total_time' => 1,
            ]
        );
        if (null !== $content) {
            $response->method('getContent')
                ->willReturn($content);
        }

        return $response;
    }

    private function createClient(
        HttpClientInterface $httpClient,
        ?SerializerInterface $serializer = null
    ): ServiceOneClient {
        $settings = $this->createMock(ServiceOneClientSetting::class);
        $settings
            ->method('getBaseUrl')
            ->willReturn('_getBaseUrl_');
        $settings
            ->method('getTimeout')
            ->willReturn(10.0);

        $serializer = $serializer ?? $this->createMock(SerializerInterface::class);

        return new ServiceOneClient(
            $httpClient,
            $settings,
            $serializer
        );
    }

}