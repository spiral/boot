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
use Spiral\Boot\ExceptionHandler;
use Spiral\Boot\Exception\FrameworkException;

class ExceptionsTest extends TestCase
{
    public function testKernelException()
    {
        $output = fopen('php://memory', 'rwb');
        ExceptionHandler::setOutput($output);
        $kernel = BrokenCore::init(['root' => __DIR__]);

        ExceptionHandler::setOutput(STDERR);

        fseek($output, 0);
        $this->assertContains('undefined', fread($output, 10000));
    }
}

class BrokenCore extends AbstractKernel
{
    protected function bootstrap()
    {
        echo $undefined;
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