<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Boot\Tests\Fixtures;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Core\BinderInterface;

class SampleBoot extends Bootloader
{
    const BOOT = true;

    const BINDINGS   = ['abc' => self::class];
    const SINGLETONS = ['single' => self::class];

    public function boot(BinderInterface $binder)
    {
        $binder->bind('cde', new SampleClass());
    }
}