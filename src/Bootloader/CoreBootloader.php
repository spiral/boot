<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot\Bootloader;

use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\Finalizer;
use Spiral\Boot\FinalizerInterface;
use Spiral\Boot\Memory;
use Spiral\Config\ConfigFactory;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Config\Loader\DirectoryLoader;
use Spiral\Core\Bootloader\Bootloader;
use Spiral\Core\ConfigsInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Core\MemoryInterface;
use Spiral\Files\Files;
use Spiral\Files\FilesInterface;

final class CoreBootloader extends Bootloader
{
    const SINGLETONS = [
        FilesInterface::class        => Files::class,
        FinalizerInterface::class    => Finalizer::class,
        ConfigsInterface::class      => ConfiguratorInterface::class,
        ConfiguratorInterface::class => ConfigFactory::class,
        MemoryInterface::class       => [self::class, 'memory'],
        ConfigFactory::class         => [self::class, 'configFactory'],
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
        return new ConfigFactory(new DirectoryLoader($directories->get('config'), $factory), true);
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
        return new Memory($directories->get('cache'), $files);
    }
}