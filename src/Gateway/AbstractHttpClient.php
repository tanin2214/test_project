<?php

namespace App\Gateway;

use App\Contract\Gateway\HttpClientSettingInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class AbstractHttpClient
{
    protected HttpClientInterface $client;
    private HttpClientSettingInterface $settings;

    protected SerializerInterface $serializer;

    public function __construct(HttpClientInterface $client, HttpClientSettingInterface $settings, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->settings = $settings;
        $this->serializer = $serializer;
    }

    /**
     * @param  array<mixed>     $options
     */
    protected function request(string $method, string $url, array $options = []): ResponseInterface
    {
        try {
            $defaultOptions = [
                'base_uri' => $this->settings->getBaseUrl(),
                'timeout' => $this->settings->getTimeout(),
            ];

            $options = array_merge($defaultOptions, $options);

            $response = $this->client->request($method, $url, $options);

            $response->getContent();
            $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            //взм Логирование - обработка
            throw new \Exception($e->getMessage());
        } catch (HttpExceptionInterface $e) {
            //взм Логирование - обработка
            throw new \Exception($e->getMessage());
        }

        return $response;
    }

    public function mapping(string $data, string $type)
    {
        try {
            $result = $this->serializer->deserialize($data, $type, 'json');
        } catch (Throwable $e) {
            throw new \Exception('Could not parse response: ' . $e->getMessage());
        }

        return $result;
    }

    public function getSettings(): HttpClientSettingInterface
    {
        return $this->settings;
    }
}