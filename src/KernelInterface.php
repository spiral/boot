<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot;

use Spiral\Boot\Exception\FrameworkException;

interface KernelInterface
{
    /**
     * Add new dispatcher. This method must only be called before method `serve`
     * will be invoked.
     *
     * @param DispatcherInterface $dispatcher
     */
    public function addDispatcher(DispatcherInterface $dispatcher);

    /**
     * Start application and serve user requests using selected dispatcher or throw
     * an exception.
     *
     * @throws FrameworkException
     * @throws \Throwable
     */
    public function serve();
}