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
use Spiral\Boot\DispatcherInterface;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Boot\Tests\Fixtures\TestCore;
use Throwable;

class KernelTest extends TestCase
{
    /**
     * @expectedException \Spiral\Boot\Exception\BootException
     * @throws Throwable
     */
    public function testKernelException(): void
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $kernel->serve();
    }

    /**
     * @throws Throwable
     */
    public function testDispatcher(): void
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $d = new class() implements DispatcherInterface {
            public $fired = false;

            public function canServe(): bool
            {
                return true;
            }

            public function serve(): void
            {
                $this->fired = true;
            }
        };
        $kernel->addDispatcher($d);
        $this->assertFalse($d->fired);

        $kernel->serve();
        $this->assertTrue($d->fired);
    }

    /**
     * @throws Throwable
     */
    public function testDispatcherServeArgs(): void
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $d = new class() implements DispatcherInterface {
            public $fired = false;
            public $args = [];

            public function canServe(): bool
            {
                return true;
            }

            public function serve(bool $arg1 = false, int $arg2 = 3): void
            {
                $this->fired = true;
                $this->args = [$arg1, $arg2];
            }
        };
        $kernel->addDispatcher($d);

        $kernel->serve();
        $this->assertEquals([false, 3], $d->args);

        $kernel->serve(true, 1);
        $this->assertEquals([true, 1], $d->args);
    }

    /**
     * @throws Throwable
     */
    public function testEnv(): void
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $this->assertSame(
            'VALUE',
            $kernel->getContainer()->get(EnvironmentInterface::class)->get('INTERNAL')
        );
    }
}
