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
use Spiral\Boot\BootloadManager;
use Spiral\Boot\Tests\Fixtures\BootloaderA;
use Spiral\Boot\Tests\Fixtures\BootloaderB;
use Spiral\Core\Container;

class DependenciesTest extends TestCase
{
    public function testDep()
    {
        $c = new Container();

        $b = new BootloadManager($c);

        $b->bootload([BootloaderA::class]);

        $this->assertTrue($c->has('a'));
        $this->assertFalse($c->has('b'));
    }

    public function testDep2()
    {
        $c = new Container();

        $b = new BootloadManager($c);

        $b->bootload([BootloaderB::class]);

        $this->assertTrue($c->has('a'));
        $this->assertTrue($c->has('b'));
    }
}