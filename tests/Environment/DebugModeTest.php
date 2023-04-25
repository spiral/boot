<?php

declare(strict_types=1);

namespace Spiral\Tests\Boot\Environment;

use Mockery as m;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Spiral\Boot\Environment\DebugMode;
use Spiral\Boot\EnvironmentInterface;

final class DebugModeTest extends TestCase
{
    public function testDetectWithoutEnvironmentVariable(): void
    {
        $env = m::mock(EnvironmentInterface::class);

        $env->shouldReceive('get')->with('DEBUG')->andReturnNull();

        $enum = DebugMode::detect($env);

        $this->assertSame(DebugMode::Disabled, $enum);
    }

    #[DataProvider('envVariablesDataProvider')]
    public function testDetectWithWrongEnvironmentVariable($name, DebugMode $expected): void
    {
        $env = m::mock(EnvironmentInterface::class);

        $env->shouldReceive('get')->with('DEBUG')->andReturn($name);

        $enum = DebugMode::detect($env);

        $this->assertSame($expected, $enum);

        if ($enum === DebugMode::Enabled) {
            $this->assertTrue($enum->isEnabled());
        } else {
            $this->assertFalse($enum->isEnabled());
        }
    }

    public static function envVariablesDataProvider(): \Traversable
    {
        yield [true, DebugMode::Enabled];
        yield ['true', DebugMode::Enabled];
        yield ['1', DebugMode::Enabled];
        yield ['on', DebugMode::Enabled];
        yield ['false', DebugMode::Disabled];
        yield ['0', DebugMode::Disabled];
        yield ['off', DebugMode::Disabled];
        yield [false, DebugMode::Disabled];
    }
}
