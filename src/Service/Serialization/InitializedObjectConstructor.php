<?php

declare(strict_types=1);

namespace App\Service\Serialization;

use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Visitor\DeserializationVisitorInterface;

class InitializedObjectConstructor implements ObjectConstructorInterface
{
    private ObjectConstructorInterface $fallbackConstructor;

    public function __construct(ObjectConstructorInterface $fallbackConstructor)
    {
        $this->fallbackConstructor = $fallbackConstructor;
    }

    /**
     * @param mixed               $data
     * @param array<string|array> $type ["name" => string, "params" => array]
     */
    public function construct(
        DeserializationVisitorInterface $visitor,
        ClassMetadata $metadata,
        $data,
        array $type,
        DeserializationContext $context
    ): ?object {

        if ($context->hasAttribute('target') && 1 === $context->getDepth()) {
            return $context->getAttribute('target');
        }

        return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type, $context);
    }
}
