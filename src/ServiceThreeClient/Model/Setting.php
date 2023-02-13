<?php

declare(strict_types=1);

namespace App\ServiceThreeClient\Model;

class Setting
{
    private string $filed1;

    private bool $field2;

    private array $field3;

    public function getFiled1(): string
    {
        return $this->filed1;
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