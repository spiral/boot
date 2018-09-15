<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Boot\Environment;
use Spiral\Boot\EnvironmentInterface;

class EnvironmentTest extends TestCase
{
    public function testDirectories()
    {
        $core = TestCore::init([
            'root' => __DIR__
        ], new Environment([
            'key' => 'value'
        ]));

        /** @var EnvironmentInterface $env */
        $env = $core->getContainer()->get(EnvironmentInterface::class);

        $env->saveData("test", "data");
        $this->assertFileExists(__DIR__ . '/cache/test.php');
        $this->assertSame("data", $env->loadData("test"));

        unlink(__DIR__ . '/cache/test.php');
        $this->assertSame(null, $env->loadData("test"));
    }
}