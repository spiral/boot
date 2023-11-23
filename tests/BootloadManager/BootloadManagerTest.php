<?php

declare(strict_types=1);

namespace Spiral\Tests\Boot\BootloadManager;

use Spiral\Boot\BootloadManager\BootloadManager;
use Spiral\Boot\BootloadManager\Initializer;
use Spiral\Boot\BootloadManager\InitializerInterface;
use Spiral\Core\Container;
use Spiral\Tests\Boot\Fixtures\BootloaderA;
use Spiral\Tests\Boot\Fixtures\BootloaderB;
use Spiral\Tests\Boot\Fixtures\SampleBoot;
use Spiral\Tests\Boot\Fixtures\SampleBootWithMethodBoot;
use Spiral\Tests\Boot\Fixtures\SampleClass;
use Spiral\Tests\Boot\TestCase;

final class BootloadManagerTest extends TestCase
{
    public function testWithoutInvokerStrategy(): void
    {
        $this->container->bind(InitializerInterface::class, new Initializer($this->container, $this->container));

        $bootloader = new BootloadManager(
            $this->container,
            $this->container,
            $this->container,
            $this->container->get(InitializerInterface::class)
        );

        $bootloader->bootload($classes = [
            SampleClass::class,
            SampleBootWithMethodBoot::class,
            SampleBoot::class,
        ], [
            static function(Container $container, SampleBoot $boot) {
                $container->bind('efg', $boot);
            }
        ], [
            static function(Container $container, SampleBoot $boot) {
                $container->bind('ghi', $boot);
            }
        ]);

        $this->assertTrue($this->container->has('abc'));
        $this->assertTrue($this->container->hasInstance('cde'));
        $this->assertTrue($this->container->hasInstance('def'));
        $this->assertTrue($this->container->hasInstance('efg'));
        $this->assertTrue($this->container->has('single'));
        $this->assertTrue($this->container->has('ghi'));
        $this->assertNotInstanceOf(SampleBoot::class, $this->container->get('efg'));
        $this->assertInstanceOf(SampleBoot::class, $this->container->get('ghi'));

        $classes = \array_filter($classes, static fn(string $class): bool => $class !== SampleClass::class);
        $this->assertSame(\array_merge($classes, [
            BootloaderA::class,
            BootloaderB::class,
        ]), $bootloader->getClasses());
    }
}
