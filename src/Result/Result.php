<?php

declare(strict_types=1);

namespace App\Result;

class Result implements ResultInterface
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
