<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Spiral\Boot\Environment;
use Spiral\Boot\Tests\Fixtures\TestConfig;
use Spiral\Boot\Tests\Fixtures\TestCore;
use Spiral\Core\ContainerScope;

class FunctionsTest extends TestCase
{
    public function testSpiral(): void
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ]);

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function (): void {
            $this->assertSame(['key' => 'value'], spiral(TestConfig::class)->toArray());
        });
    }

    public function testEnv(): void
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ], new Environment([
            'key' => '(true)'
        ]));

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function (): void {
            $this->assertSame(true, env('key'));
        });
    }

    public function testDirectory(): void
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ]);

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function (): void {
            $this->assertDir(__DIR__ . '/config', directory('config'));
        });
    }

    /**
     * @expectedException \Spiral\Core\Exception\ScopeException
     */
    public function testSpiralException(): void
    {
        spiral(TestConfig::class);
    }

    /**
     * @expectedException \Spiral\Core\Exception\ScopeException
     */
    public function testSpiralException2(): void
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ]);

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function (): void {
            spiral(Invalid::class);
        });
    }

    /**
     * @expectedException \Spiral\Core\Exception\ScopeException
     */
    public function testEnvException(): void
    {
        env('key');
    }

    /**
     * @expectedException \Spiral\Core\Exception\ScopeException
     */
    public function testDirectoryException(): void
    {
        directory('key');
    }

    private function assertDir($path, $value): void
    {
        $path = str_replace(['\\', '//'], '/', $path);
        $this->assertSame(rtrim($path, '/') . '/', $value);
    }
}
