<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;

interface RequestPropertyResolverInterface
{
    public function supports(string $className): bool;

    /**
     * @param object $dto
     */
    public function resolve(Request $request, $dto): void;
}
