<?php

declare(strict_types=1);

namespace Spiral\Tests\Boot\BootloadManager\Checker;

use PHPUnit\Framework\TestCase;
use Spiral\Boot\BootloadManager\Checker\CanBootedChecker;
use Spiral\Boot\BootloadManager\ClassesRegistry;
use Spiral\Tests\Boot\Fixtures\AbstractBootloader;
use Spiral\Tests\Boot\Fixtures\BootloaderA;
use Spiral\Tests\Boot\Fixtures\SampleClass;

final class CanBootedCheckerTest extends TestCase
{
    public function testCanInitializeSuccess(): void
    {
        $checker = new CanBootedChecker(new ClassesRegistry());

        $this->assertTrue($checker->canInitialize(BootloaderA::class));
        $this->assertTrue($checker->canInitialize(new BootloaderA()));
    }

    public function testCanInitializeBootloaderAlreadyBooted(): void
    {
        $registry = new ClassesRegistry();
        $registry->register(BootloaderA::class);

        $checker = new CanBootedChecker($registry);

        $this->assertFalse($checker->canInitialize(BootloaderA::class));
        $this->assertFalse($checker->canInitialize(new BootloaderA()));
    }

    public function testCanInitializeAbstractBootloader(): void
    {
        $checker = new CanBootedChecker(new ClassesRegistry());

        $this->assertFalse($checker->canInitialize(AbstractBootloader::class));
    }

    public function testCanInitializeNotImplementInterface(): void
    {
        $checker = new CanBootedChecker(new ClassesRegistry());

        $this->assertFalse($checker->canInitialize(SampleClass::class));
    }
}
