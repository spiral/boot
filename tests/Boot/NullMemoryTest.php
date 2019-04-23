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
use Spiral\Boot\MemoryInterface;
use Spiral\Boot\NullMemory;

class NullMemoryTest extends TestCase
{
    public function testLoadData()
    {
        $memory = new NullMemory();
        $this->assertInstanceOf(MemoryInterface::class, $memory);
        $this->assertNull($memory->loadData('test'));
    }

    public function testSaveData()
    {
        $memory = new NullMemory();
        $this->assertInstanceOf(MemoryInterface::class, $memory);
        $memory->saveData('test', null);
    }
}