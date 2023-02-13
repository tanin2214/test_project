<?php

declare(strict_types=1);

namespace App\Service\Serialization;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class NullAwareHandlersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $visitor = $container->getDefinition('jms_serializer.custom_json_deserialization_visitor');

        $types = [];
        foreach ($container->findTaggedServiceIds('jms_serializer.subscribing_handler') as $id => $tags) {
            $def = $container->getDefinition($id);
            $class = $def->getClass();

            /** @phpstan-ignore-next-line */
            $ref = new ReflectionClass($class);
            if (!$ref->implementsInterface(SubscribingHandlerInterface::class) || !$ref->implementsInterface(NullAwareHandlerInterface::class)) {
                continue;
            }

            /** @phpstan-ignore-next-line */
            foreach (call_user_func([$class, 'getSubscribingMethods']) as $methodData) {
                if (!isset($methodData['type'])) {
                    continue;
                }

                $types[] = $methodData['type'];
            }
        }

        $visitor->addMethodCall('setNullAwareTypes', [array_unique($types)]);
    }
}
