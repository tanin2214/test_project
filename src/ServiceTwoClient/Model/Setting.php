<?php

declare(strict_types=1);

namespace App\ServiceTwoClient\Model;

class Setting
{
    private string $filed1;

    private bool $field2;

    private int $field3;

    public function getFiled1(): string
    {
        return $this->filed1;
    }

    public function isField2(): bool
    {
        return $this->field2;
    }

    public function getField3(): int
    {
        return $this->field3;
    }
}