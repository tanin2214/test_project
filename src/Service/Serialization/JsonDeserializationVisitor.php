<?php

declare(strict_types=1);

namespace App\Service\Serialization;

use JMS\Serializer\Exception\NotAcceptableException;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Visitor\DeserializationVisitorInterface;

class JsonDeserializationVisitor implements DeserializationVisitorInterface
{
    private DeserializationVisitorInterface $visitor;
    private GraphNavigatorInterface $navigator;
    /**
     * @var string[]
     */
    private array $nullAwareTypes;

    /**
     * @param DeserializationVisitorInterface $visitor
     * @param string[]                        $nullAwareTypes
     */
    public function __construct(DeserializationVisitorInterface $visitor, array $nullAwareTypes)
    {
        $this->visitor = $visitor;
        $this->nullAwareTypes = $nullAwareTypes;
    }

    public function setNavigator(GraphNavigatorInterface $navigator): void
    {
        $this->navigator = $navigator;
        $this->visitor->setNavigator($navigator);
    }

    /**
     * @param mixed   $data
     * @param mixed[] $type
     */
    public function visitNull($data, array $type)
    {
        $this->visitor->visitNull($data, $type);

        return null;
    }

    /**
     * @param mixed   $data
     * @param mixed[] $type
     */
    public function visitString($data, array $type): string
    {
        return $this->visitor->visitString($data, $type);
    }

    /**
     * @param mixed   $data
     * @param mixed[] $type
     */
    public function visitBoolean($data, array $type): bool
    {
        return $this->visitor->visitBoolean($data, $type);
    }

    /**
     * @param mixed   $data
     * @param mixed[] $type
     */
    public function visitInteger($data, array $type): int
    {
        return $this->visitor->visitInteger($data, $type);
    }

    /**
     * @param mixed   $data
     * @param mixed[] $type
     */
    public function visitDouble($data, array $type): float
    {
        return $this->visitor->visitDouble($data, $type);
    }

    /**
     * @param  mixed   $data
     * @param  mixed[] $type
     * @return mixed[]
     */
    public function visitArray($data, array $type): array
    {
        return $this->visitor->visitArray($data, $type);
    }

    public function visitDiscriminatorMapProperty($data, ClassMetadata $metadata): string
    {
        return $this->visitor->visitDiscriminatorMapProperty($data, $metadata);
    }

    /**
     * @param ClassMetadata $metadata
     * @param object        $object
     * @param mixed[]       $type
     */
    public function startVisitingObject(ClassMetadata $metadata, object $object, array $type): void
    {
        $this->visitor->startVisitingObject($metadata, $object, $type);
    }

    /**
     * @param  PropertyMetadata $metadata
     * @param  mixed            $data
     * @return mixed
     */
    public function visitProperty(PropertyMetadata $metadata, $data)
    {
        $name = $metadata->serializedName ?? '';

        if (null === $data) {
            return null;
        }

        if (!\is_array($data)) {
            throw new RuntimeException(sprintf('Invalid data %s (%s), expected "%s".', json_encode($data), $metadata->type['name'] ?? '', $metadata->class));
        }

        if (true === $metadata->inline) {
            if (!$metadata->type) {
                throw RuntimeException::noMetadataForProperty($metadata->class, $metadata->name);
            }

            return $this->navigator->accept($data, $metadata->type);
        }

        if (!array_key_exists($name, $data)) {
            throw new NotAcceptableException();
        }

        if (!$metadata->type) {
            throw RuntimeException::noMetadataForProperty($metadata->class, $metadata->name);
        }

        if (null === $data[$name] && !in_array($metadata->type['name'], $this->nullAwareTypes)) {
            return null;
        }

        return $this->navigator->accept($data[$name], $metadata->type);
    }

    /**
     * @param  ClassMetadata $metadata
     * @param  mixed         $data
     * @param  mixed[]       $type
     * @return object
     */
    public function endVisitingObject(ClassMetadata $metadata, $data, array $type): object
    {
        return $this->visitor->endVisitingObject($metadata, $data, $type);
    }

    /**
     * @param  mixed $data
     * @return mixed
     */
    public function getResult($data)
    {
        return $this->visitor->getResult($data);
    }

    /**
     * @param  mixed $data
     * @return mixed
     */
    public function prepare($data)
    {
        return $this->visitor->prepare($data);
    }
}
