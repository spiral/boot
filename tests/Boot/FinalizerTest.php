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
use Spiral\Boot\Finalizer;

class FinalizerTest extends TestCase
{
    public function testFinalize()
    {
        $f = new Finalizer();

        $value = 1;
        $f->addFinalizer(function () use (&$value) {
            $value = 2;
        });

        $this->assertSame(1, $value);
        $f->finalize();
        $this->assertSame(2, $value);
    }
}