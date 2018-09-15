<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Boot\DispatcherInterface;

class KernelTest extends TestCase
{
    /**
     * @expectedException \Spiral\Boot\Exceptions\FrameworkException
     */
    public function testKernelException()
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $kernel->serve();
    }

    public function testDispatcher()
    {
        $kernel = TestCore::init([
            'root' => __DIR__
        ]);

        $d = new TestDispatcher();
        $kernel->addDispatcher($d);
        $this->assertFalse($d->fired);

        $kernel->serve();
        $this->assertTrue($d->fired);
    }
}

class TestDispatcher implements DispatcherInterface
{
    public $fired = false;

    public function canServe(): bool
    {
        return true;
    }

    public function serve()
    {
        $this->fired = true;
    }
}