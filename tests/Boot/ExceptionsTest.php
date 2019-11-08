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
use Spiral\Boot\ExceptionHandler;
use Spiral\Boot\Tests\Fixtures\BrokenCore;

class ExceptionsTest extends TestCase
{
    public function testKernelException(): void
    {
        $output = fopen('php://memory', 'rwb');
        ExceptionHandler::setOutput($output);
        $kernel = BrokenCore::init(['root' => __DIR__]);

        ExceptionHandler::setOutput(STDERR);

        fseek($output, 0);
        $this->assertContains('undefined', fread($output, 10000));
    }
}
