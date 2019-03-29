<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot;

/**
 * Used to close resources and connections for long running processes.
 */
interface FinalizerInterface
{
    /**
     * Finalizers are executed after every request and used for garbage collection
     * or to close open connections.
     *
     * @param callable $finalizer
     */
    public function addFinalizer(callable $finalizer);

    /**
     * Finalize execution.
     */
    public function finalize();
}