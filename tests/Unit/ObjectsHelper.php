<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use ReflectionClass;

trait ObjectsHelper
{
    /**
     * @return mixed
     */
    protected static function getObjectProp(object $object, string $propertyName)
    {
        $reflection = new ReflectionClass($object);

        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * @return mixed
     */
    protected static function getObjectPropViaGetter(object $object, string $propertyName)
    {
        $method = self::getGetterMethodName($propertyName);

        return $object->{$method}();
    }

    protected static function getGetterMethodName(string $propertyName): string
    {
        return 'get' . ucfirst($propertyName);
    }

    /**
     * @param array<string,mixed> $propValues
     */
    protected static function setObjectProps(object $object, array $propValues): void
    {
        $reflection = new ReflectionClass($object);

        foreach ($propValues as $propName => $propValue) {
            self::setObjectProp($object, $reflection, $propName, $propValue);
        }
    }

    /**
     * @internal
     * @param mixed                   $propValue
     * @param ReflectionClass<object> $reflection
     */
    private static function setObjectProp(
        object $object,
        ReflectionClass $reflection,
        string $propName,
        $propValue
    ): void {
        $property = $reflection->getProperty($propName);
        $property->setAccessible(true);
        $property->setValue($object, $propValue);
    }

    /**
     * @param  array<int,mixed> $parameters
     * @return mixed
     */
    private static function invokeMethod(object $object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
