<?php
declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot;

/**
 * Dispatchers are general application flow controllers, system should start them and pass exception
 * or instance of snapshot into them when error happens.
 */
interface DispatcherInterface
{
    /**
     * Must return true if dispatcher expects to handle requests in a current environment.
     *
     * @return bool
     */
    public function canServe(): bool;

    /**
     * Start request execution.
     */
    public function serve();
}