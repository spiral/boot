<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Boot\AbstractKernel;
use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\Exceptions\FrameworkException;

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

        $this->assertDir(__DIR__ . '/runtime', $dirs->get('runtime'));
        $this->assertDir(__DIR__ . '/runtime/cache', $dirs->get('cache'));
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

class TestCore extends AbstractKernel
{
    protected function bootstrap()
    {
    }

    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Normalizes directory list and adds all required alises.
     *
     * @param array $directories
     * @return array
     */
    protected function mapDirectories(array $directories): array
    {
        if (!isset($directories['root'])) {
            throw new FrameworkException("Missing required directory `root`.");
        }

        if (!isset($directories['app'])) {
            $directories['app'] = $directories['root'] . '/app/';
        }

        return array_merge([
            // public root
            'public'    => $directories['root'] . '/public/',

            // data directories
            'runtime'   => $directories['root'] . '/runtime/',
            'cache'     => $directories['root'] . '/runtime/cache/',

            // application directories
            'config'    => $directories['app'] . '/config/',
            'resources' => $directories['app'] . '/resources/',
        ], $directories);
    }
}