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

class KernelTest extends TestCase
{
    /**
     * @expectedException \Spiral\Boot\Exception\BootException
     */
    public function testKernelException(): void
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $kernel->serve();
    }

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
