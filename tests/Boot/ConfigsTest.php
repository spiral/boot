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
use Spiral\Boot\Tests\Fixtures\TestConfig;
use Spiral\Boot\Tests\Fixtures\TestCore;

class ConfigsTest extends TestCase
{
    public function testDirectories()
    {
        $core = TestCore::init([
            'root'   => __DIR__,
            'config' => __DIR__ . '/config'
        ]);

        /** @var TestConfig $config */
        $config = $core->getContainer()->get(TestConfig::class);

        $this->assertSame(['key' => 'value'], $config->toArray());
    }
}