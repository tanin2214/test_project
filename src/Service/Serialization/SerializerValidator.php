<?php

declare(strict_types=1);

namespace App\Service\Serialization;

use App\Exception\ValidationException;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SerializerValidator implements SerializerInterface
{
    private \JMS\Serializer\SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(\JMS\Serializer\SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(
        $data,
        string $format,
        ?SerializationContext $context = null,
        ?string $type = null
    ): string {
        return $this->serializer->serialize($data, $format, $context, $type);
    }

    /**
     * {@inheritdoc}
     * @return mixed
     */
    public function deserialize(string $data, string $type, string $format, ?DeserializationContext $context = null)
    {
        $object = $this->serializer->deserialize($data, $type, $format, $context);
        $errors = $this->validator->validate($object);

        if (!$errors->count()) {
            return $object;
        }

        throw new ValidationException('Ошибка валидации данных', $errors);
    }
}
