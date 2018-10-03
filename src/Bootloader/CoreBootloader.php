<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Bootloader;

use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\Memory;
use Spiral\Config;
use Spiral\Core\Bootloader\Bootloader;
use Spiral\Core\ConfiguratorInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Core\MemoryInterface;
use Spiral\Files\Files;
use Spiral\Files\FilesInterface;

final class CoreBootloader extends Bootloader
{
    const SINGLETONS = [
        FilesInterface::class               => Files::class,
        MemoryInterface::class              => [self::class, 'memory'],
        ConfiguratorInterface::class        => Config\ConfiguratorInterface::class,
        Config\ConfiguratorInterface::class => Config\ConfigFactory::class,
        Config\ConfigFactory::class         => [self::class, 'configFactory'],
    ];

    /**
     * @param DirectoriesInterface $directories
     * @param FactoryInterface     $factory
     * @return ConfiguratorInterface
     */
    protected function configFactory(
        DirectoriesInterface $directories,
        FactoryInterface $factory
    ): ConfiguratorInterface {
        return new  Config\ConfigFactory(
            new Config\Loader\DirectoryLoader($directories->get('config'), $factory),
            true
        );
    }

    /**
     * @param DirectoriesInterface $directories
     * @param FilesInterface       $files
     * @return MemoryInterface
     */
    protected function memory(
        DirectoriesInterface $directories,
        FilesInterface $files
    ): MemoryInterface {
        return new Memory(
            $directories->get('cache'),
            $files
        );
    }
}