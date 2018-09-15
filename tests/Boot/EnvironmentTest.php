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
    public function testValue()
    {
        $env = $this->getEnv(['key' => 'value']);

        $this->assertSame('value', $env->get('key'));
    }

    public function testDefault()
    {
        $env = $this->getEnv(['key' => 'value']);

        $this->assertSame('default', $env->get('other', 'default'));
    }

    public function testID()
    {
        $env = $this->getEnv(['key' => 'value']);

        $id = $env->getID();

        $this->assertNotEmpty($id);

        $env->set('other', 'value');
        $this->assertNotSame($id, $env->getID());

        $this->assertSame('value', $env->get('other', 'default'));
    }


    public function testNormalize()
    {
        $env = $this->getEnv(['key' => 'true', 'other' => false]);
        $this->assertSame(true, $env->get('key'));
        $this->assertSame(false, $env->get('other'));
    }

    /**
     * @param array $env
     * @return EnvironmentInterface
     *
     * @throws \Error
     */
    protected function getEnv(array $env): EnvironmentInterface
    {
        $core = TestCore::init(['root' => __DIR__], new Environment($env));

        return $core->getContainer()->get(EnvironmentInterface::class);
    }
}