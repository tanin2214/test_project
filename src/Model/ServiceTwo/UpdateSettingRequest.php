<?php

declare(strict_types=1);

namespace App\Model\ServiceTwo;

use App\ArgumentResolver\RequestDTOInterface;
use JMS\Serializer\Annotation as Serializer;

class UpdateSettingRequest implements RequestDTOInterface
{
    /**
     * @Serializer\Type("string")
     */
    private string $field1;

    /**
     * @Serializer\Type("boolean")
     */
    private bool $field2;

    /**
     * @Serializer\Type("array")
     */
    private array $field3;

    public function getField1(): string
    {
        return $this->field1;
    }

    public function isField2(): bool
    {
        return $this->field2;
    }

    public function getField3(): array
    {
        return $this->field3;
    }
}