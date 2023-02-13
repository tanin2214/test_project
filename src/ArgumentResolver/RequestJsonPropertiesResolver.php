<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use InvalidArgumentException;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Exception\ValidationFailedException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestJsonPropertiesResolver implements RequestPropertyResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(string $className): bool
    {
        return in_array(RequestDTOInterface::class, class_implements($className) ?: [], true);
    }

    /**
     * @param RequestDTOInterface $dto
     */
    public function resolve(Request $request, $dto): void
    {
        $this->validateRequest($request);
        $this->deserializeObject($dto, $request);
        $this->validateObject($dto, $request);
    }

    private function deserializeObject(RequestDTOInterface $dto, Request $request): void
    {
        try {
            $context = new DeserializationContext();
            $context->setAttribute('target', $dto);
            $this->serializer->deserialize((string) $request->getContent(), get_class($dto), 'json', $context);

        } catch (ValidationFailedException $exception) {
            throw new \Exception('Ошибка валидации данных запроса', $request, $exception->getConstraintViolationList());
        }
    }

    private function validateRequest(Request $request): void
    {
        try {
            \GuzzleHttp\json_decode((string)$request->getContent(), true);
        } catch (InvalidArgumentException $e) {
            throw new \Exception('Невалидный json');
        }
    }

    private function validateObject(RequestDTOInterface $dto, Request $request): void
    {
        $errors = $this->validator->validate($dto);

        if (!$errors->count()) {
            return;
        }

        $exception = new \Exception('Ошибка валидации данных запроса');


        throw $exception;
    }
}
