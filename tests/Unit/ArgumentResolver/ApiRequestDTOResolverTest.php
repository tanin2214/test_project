<?php

declare(strict_types=1);

namespace App\Tests\Unit\ArgumentResolver;

use App\ArgumentResolver\ApiRequestResolver;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;


class ApiRequestDTOResolverTest extends TestCase
{

    public function testSupportsForArgumentOfType(?string $argumentType): void
    {
        $request = $this->createMock(Request::class);

        $argumentMeta = $this->createMock(ArgumentMetadata::class);
        $argumentMeta->method('getType')->willReturn($argumentType);

        $resolver = new ApiRequestResolver([]);

        self::assertFalse($resolver->supports($request, $argumentMeta));
    }

    public function dataSupportsForArgumentOfType(): array
    {
        return [
            'No type' => [
                null,
            ],
            'Not existing class name' => [
                'BlaBlaBlaNotExistingClassName',
            ],
        ];
    }

    /**
     * @covers ::supports
     */
    public function testSupportsForNoPropertyResolvers(): void
    {
        $request = $this->createMock(Request::class);

        $argumentMeta = $this->createMock(ArgumentMetadata::class);
        $argumentMeta->method('getType')->willReturn(stdClass::class);

        $resolver = new ApiRequestResolver([]);

        self::assertFalse($resolver->supports($request, $argumentMeta));
    }
}
