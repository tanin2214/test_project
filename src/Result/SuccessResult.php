<?php

declare(strict_types=1);

namespace App\Result;

class SuccessResult extends Result
{
    public function __construct()
    {
        parent::__construct(['result' => 'OK']);
    }
}
