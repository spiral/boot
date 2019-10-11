<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Boot\Bootloader;

use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\Memory;
use Spiral\Boot\MemoryInterface;
use Spiral\Config\ConfigManager;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Config\Loader\DirectoryLoader;
use Spiral\Core\ConfigsInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Files\Files;
use Spiral\Files\FilesInterface;

/**
 * Bootloads core services.
 */
final class CoreBootloader extends Bootloader
{
    protected const SINGLETONS = [
        FilesInterface::class        => Files::class,
        MemoryInterface::class       => [self::class, 'memory'],
        ConfigsInterface::class      => ConfiguratorInterface::class,
        ConfiguratorInterface::class => ConfigManager::class,
        ConfigManager::class         => [self::class, 'configManager'],
    ];

    /**
     * @param DirectoriesInterface $directories
     * @param FactoryInterface     $factory
     * @return ConfiguratorInterface
     */
    private function configManager(
        DirectoriesInterface $directories,
        FactoryInterface $factory
    ): ConfiguratorInterface {
        return new ConfigManager(new DirectoryLoader($directories->get('config'), $factory), true);
    }

    /**
     * @param DirectoriesInterface $directories
     * @param FilesInterface       $files
     * @return MemoryInterface
     */
    private function memory(
        DirectoriesInterface $directories,
        FilesInterface $files
    ): MemoryInterface {
        return new Memory($directories->get('cache'), $files);
    }
}
