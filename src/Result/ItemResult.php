<?php

declare(strict_types=1);

namespace App\Result;

class ItemResult extends Result
{
    public function __construct($data)
    {
        parent::__construct(['result' => $data]);
    }
}
