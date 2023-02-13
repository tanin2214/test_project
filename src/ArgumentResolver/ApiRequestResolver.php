<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ApiRequestResolver implements ArgumentValueResolverInterface
{
    /**
     * @var RequestPropertyResolverInterface[]|iterable
     */
    private iterable $propertyResolvers;

    public function __construct(iterable $propertyResolvers)
    {
        $this->propertyResolvers = $propertyResolvers;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $className = $argument->getType();
        if (null === $className || !class_exists($className)) {
            return false;
        }

        foreach ($this->propertyResolvers as $propertyResolver) {
            if ($propertyResolver->supports($className)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return iterable<object>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $className = $argument->getType();
        $dto = new $className();

        foreach ($this->propertyResolvers as $propertyResolver) {
            if ($propertyResolver->supports($className)) {
                $propertyResolver->resolve($request, $dto);
            }
        }

        yield $dto;
    }
}
