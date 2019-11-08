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
use Spiral\Boot\Tests\Fixtures\SampleBoot;
use Spiral\Boot\Tests\Fixtures\SampleClass;
use Spiral\Core\Container;

class BootloadersTest extends TestCase
{
    public function testSchemaLoading(): void
    {
        $container = new Container();

        $bootloader = new BootloadManager($container);
        $bootloader->bootload([SampleClass::class, SampleBoot::class]);

        $this->assertTrue($container->has('abc'));
        $this->assertTrue($container->hasInstance('cde'));
        $this->assertTrue($container->has('single'));

        $this->assertSame([SampleClass::class, SampleBoot::class], $bootloader->getClasses());
    }

    /**
     * @expectedException \Spiral\Core\Exception\Container\NotFoundException
     */
    public function testException(): void
    {
        $container = new Container();

        $bootloader = new BootloadManager($container);
        $bootloader->bootload(['Invalid']);
    }
}
