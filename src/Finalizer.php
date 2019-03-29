<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Boot;

final class Finalizer implements FinalizerInterface
{
    /** @var callable[] */
    private $finalizers = [];

    /**
     * @inheritdoc
     */
    public function addFinalizer(callable $finalizer)
    {
        $this->finalizers[] = $finalizer;
    }

    /**
     * @inheritdoc
     */
    public function finalize(bool $terminate = false)
    {
        foreach ($this->finalizers as $finalizer) {
            call_user_func($finalizer, $terminate);
        }
    }
}