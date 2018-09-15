<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Boot\ExceptionHandler;
use Spiral\Boot\AbstractKernel;

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
}