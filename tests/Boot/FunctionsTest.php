<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Spiral\Boot\Environment;
use Spiral\Core\ContainerScope;

class FunctionsTest extends TestCase
{
    public function testSpiral()
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ]);

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function () {
            $this->assertSame(['key' => 'value'], spiral(TestConfig::class)->toArray());
        });
    }

    public function testEnv()
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ], new Environment([
            'key' => '(true)'
        ]));

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function () {
            $this->assertSame(true, env('key'));
        });
    }

    public function testDirectory()
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ]);

        /** @var ContainerInterface $c */
        $c = $core->getContainer();

        ContainerScope::runScope($c, function () {
            $this->assertDir(__DIR__ . '/config', directory('config'));
        });
    }

    /**
     * @expectedException \Spiral\Core\Exceptions\ScopeException
     */
    public function testSpiralException()
    {
        spiral(TestConfig::class);
    }

    /**
     * @expectedException \Spiral\Core\Exceptions\ScopeException
     */
    public function testSpiralException2()
    {
        spiral(Invalid::class);
    }

    /**
     * @expectedException \Spiral\Core\Exceptions\ScopeException
     */
    public function testEnvException()
    {
        env("key");
    }

    /**
     * @expectedException \Spiral\Core\Exceptions\ScopeException
     */
    public function testDirectoryException()
    {
        directory("key");
    }

    private function assertDir($path, $value)
    {
        $path = str_replace(['\\', '//'], '/', $path);
        $this->assertSame(rtrim($path, '/') . '/', $value);
    }
}