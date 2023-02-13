<?php

declare(strict_types=1);

namespace App\ServiceOneClient\Model;

class Setting
{
    private string $field1;

    private bool $field2;

    /**
     * @var string[]
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

    /**
     * @return string[]
     */
    public function getField3(): array
    {
        return $this->field3;
    }
}