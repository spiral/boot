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
use Spiral\Boot\AbstractKernel;
use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\Exception\BootException;
use Spiral\Boot\Tests\Fixtures\TestCore;

class DirectoriesTest extends TestCase
{
    public function testDirectories(): void
    {
        $core = TestCore::init([
            'root' => __DIR__
        ]);

        /**
         * @var DirectoriesInterface $dirs
         */
        $dirs = $core->getContainer()->get(DirectoriesInterface::class);

        $this->assertDir(__DIR__, $dirs->get('root'));

        $this->assertDir(__DIR__ . '/app', $dirs->get('app'));

        $this->assertDir(__DIR__ . '/public', $dirs->get('public'));

        $this->assertDir(__DIR__ . '/app/config', $dirs->get('config'));
        $this->assertDir(__DIR__ . '/app/resources', $dirs->get('resources'));

        $this->assertDir(__DIR__ . '/runtime', $dirs->get('runtime'));
        $this->assertDir(__DIR__ . '/runtime/cache', $dirs->get('cache'));
    }

    /**
     * @expectedException \Spiral\Boot\Exception\BootException
     */
    public function testKernelException(): void
    {
        $core = TestCore::init([]);
    }

    public function testSetDirectory(): void
    {
        $core = TestCore::init([
            'root' => __DIR__
        ]);

        /**
         * @var DirectoriesInterface $dirs
         */
        $dirs = $core->getContainer()->get(DirectoriesInterface::class);
        $dirs->set('alias', __DIR__);

        $this->assertDir(__DIR__, $dirs->get('alias'));
    }

    public function testGetAll(): void
    {
        $core = TestCore::init([
            'root' => __DIR__
        ]);

        /**
         * @var DirectoriesInterface $dirs
         */
        $dirs = $core->getContainer()->get(DirectoriesInterface::class);

        $this->assertFalse($dirs->has('alias'));
        $dirs->set('alias', __DIR__);
        $this->assertTrue($dirs->has('alias'));

        $this->assertCount(8, $dirs->getAll());
    }

    /**
     * @expectedException \Spiral\Boot\Exception\DirectoryException
     */
    public function testGetException(): void
    {
        $core = TestCore::init([
            'root' => __DIR__
        ]);

        /**
         * @var DirectoriesInterface $dirs
         */
        $dirs = $core->getContainer()->get(DirectoriesInterface::class);
        $dirs->get('alias');
    }

    private function assertDir($path, $value): void
    {
        $path = str_replace(['\\', '//'], '/', $path);
        $this->assertSame(rtrim($path, '/') . '/', $value);
    }
}
