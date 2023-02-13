<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Contract\Gateway\GRPCClientSettingInterface;
use JMS\Serializer\SerializerInterface;
use Throwable;

class AbstractGRPCClient
{
//    protected gRPCClientInterface $client;

    private GRPCClientSettingInterface $settings;

    protected SerializerInterface $serializer;

    public function __construct(/* gRPCClientInterface $client, */ GRPCClientSettingInterface $settings, SerializerInterface $serializer)
    {
//        $this->client = $client;
        $this->settings = $settings;
        $this->serializer = $serializer;
    }

    /**
     * @param  array<mixed>     $options
     */
    protected function callRemoteProcedure(/*....args */) /*: object */
    {
//        try {
//            $response = $this->client->{method}(args)
//        } catch (TransportExceptionInterface $e) {
//
//            //взм Логирование - обработка
//            throw new \Exception($e->getMessage());
//        } catch (HttpExceptionInterface $e) {
//
//            //взм Логирование - обработка
//            throw new \Exception($e->getMessage());
//        }
//
//        return $response;
    }

    public function getSettings(): GRPCClientSettingInterface
    {
        return $this->settings;
    }
}