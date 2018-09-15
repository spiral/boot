<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;

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
}