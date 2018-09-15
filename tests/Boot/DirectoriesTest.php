<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\Kernel;

class DirectoriesTest extends TestCase
{
    public function testDirectories()
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

        $this->assertDir(__DIR__ . '/app/runtime', $dirs->get('runtime'));
        $this->assertDir(__DIR__ . '/app/runtime/cache', $dirs->get('cache'));
    }

    /**
     * @expectedException \Spiral\Boot\Exceptions\FrameworkException
     */
    public function testKernelException()
    {
        $core = TestCore::init([]);
    }

    public function testSetDirectory()
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

    public function testGetAll()
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
     * @expectedException \Spiral\Boot\Exceptions\DirectoryException
     */
    public function testGetException()
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

    private function assertDir($path, $value)
    {
        $path = str_replace(['\\', '//'], '/', $path);
        $this->assertSame(rtrim($path, '/') . '/', $value);
    }
}

class TestCore extends Kernel
{
    protected function bootstrap()
    {
    }

    public function getContainer()
    {
        return $this->container;
    }
}